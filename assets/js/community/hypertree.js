var labelType, useGradients, nativeTextSupport, animate;

(function() {
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport 
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();

var Log = {
  elem: false,
  write: function(text){
    if (!this.elem) 
      this.elem = document.getElementById('log');
    this.elem.innerHTML = text;
    this.elem.style.left = (500 - this.elem.offsetWidth / 2) + 'px';
  }
};

function removeURLParam(url, param) {
  var urlparts= url.split('?');

  if (urlparts.length >=2 ) {
    var prefix = encodeURIComponent(param) + '=';
    var pars = urlparts[1].split(/[&;]/g);

    for (var i = pars.length - 1; i >= 0; i--) {
      if (pars[i].indexOf(prefix, 0) == 0) {
        pars.splice(i, 1);
      }
      if (pars.length > 0) {
        return urlparts[0] + '?' + pars.join('&');
      } else {
        return urlparts[0];
      }
    }
  } else {
    return url;
  }
}


function generate_color_from_string(string) {
  var colors = [
    "#a00","#0a0","#00a",
    "#a0a","#0aa", "#aa0",
    "#c60","#c06","#6c0","#0c6","#60c","#06c",
    "#770","#707","#770",
    "#c66","#c66","#6c6",
    "#aa4","#4aa","#a4a"
  ];

  var sum = 0;
  for (var i = 0; i < string.length; i++) {
    sum += string.charCodeAt(i);
  }

  return colors[sum % colors.length];
}


function init(center_user, connections, current_user_id){

  console.log(center_user);
  console.log(connections);

  var json = new Array();
  var dimension = Math.min(100 / connections.length, 30);

  if (center_user != -1) {
    if (connections.length == 0) {

      var node_name;
      if (center_user == current_user_id) {
        node_name = "You";
      } else {
        node_name = center_user;
      }

      // Set up two identical nodes that will be in the same place
      // so it looks like only one user is centered. (Because 
      // apparently, you can't have a graph of one node).
      var color = generate_color_from_string(center_user);
      json.push(
      {
        "id": "1",
        "name": node_name,
        "data": {
          "$dim": dimension,
          "$color": color
        },
        "adjacencies": []
      }, 
      {
        "id": "2",
        "name": node_name,
        "data": {
          "$dim": dimension,
          "$color": color
        },
        "adjacencies": []
      });
    } else {
      var node_name;
      if (center_user == current_user_id) {
        node_name = "You";
      } else {
        node_name = center_user;
      }

      // Set up the center user
      json.push(
      {
        "id": "center",
        "name": node_name,
        "data": {
          "$dim": dimension,
          "$color": generate_color_from_string(center_user)
        },
        "adjacencies": []
      });

      // Set up all of the connections
      for (var i = 0; i < connections.length; i++) {
        if (connections[i]['user_id'] == current_user_id) {
          node_name = "You";
        } else {
          node_name = connections[i]['user_id'];
        }

        json.push(
        {
          "id": i,
          "name": node_name,
          "data": {
            "$dim": dimension,
            "$color": generate_color_from_string(connections[i]['user_id'])
          },
          "adjacencies": [
            {
              "nodeTo": "center",
              "data": {
                "$color": connections[i]['color'] 
              }
            }
          ]
        });
      }
    }
  }

  // init RGraph
  var rgraph = new $jit.RGraph({
    injectInto: 'infovis',
    // Optional: Add a background canvas that draws some concentric circles.
    background: {
      CanvasStyles: {
        strokeStyle: '#555',
        shadowBlur: 50,
        shadowColor: '#ccc'
      }
    },
    // Nodes and Edges parameters can be overridden if defined in the JSON input data. 
    // This way we can define different node types individually.
    Node: {
      overridable: true,
    },
    Edge: {
      overridable: true,
      lineWidth: 5
    },
    Label: {
      type: labelType, //Native or HTML
      size: 13,
      style: 'bold'
    },
    Events: {
      enable: true,
      type: 'Native',
      //Change cursor style when hovering a node
      onMouseEnter: function() {
        rgraph.canvas.getElement().style.cursor = 'pointer';
      },
      onMouseLeave: function() {
        rgraph.canvas.getElement().style.cursor = '';
      },
      //Add also a click handler to nodes
      onClick: function(node) {
        if(!node) return;
        // Load proper page if node clicked
        var url = document.URL.split('#')[0];
        url = removeURLParam(url, "code");
        window.location.href = url + "&code=" + node.name + "#focus_graph";
      }
    },
    // Set polar interpolation. Default's linear.
    interpolation: 'polar',
    // Change the transition effect from linearto elastic.
    transition: $jit.Trans.Elastic.easeOut,
    // Change other animation parameters.
    duration:1000,
    fps: 30,
    // Change father-child distance.
    levelDistance: 200,
  });

  // Load graph
  rgraph.loadJSON(json, 1);
  
  // Compute positions and plot
  rgraph.refresh();

  // Center the correct user
  rgraph.onClick('center');

  rgraph.controller.onBeforeCompute(rgraph.graph.getNode(rgraph.root));
}
