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
    if (!this.elem) { 
      this.elem = document.getElementById('log');
    }
    this.elem.innerHTML = text;
  }
};


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


function init(interests){

  if (interests) {
    var dimension = Math.min(25, 500 / interests.length);
    var json = new Array();
    for (var i = 0; i < interests.length; i++) {
      var color = generate_color_from_string(interests[i]['id'] + interests[i]['name'] + interests[i]['short_name']);
      var shape = "circle";

      if (interests[i]['is_mine']) {
        color = "#cc0";
        shape = "star";
      }

      json.push(
        {
          "id": i,
          "name": interests[i]['short_name'],
          "data": {
            "$color": color,
            "$type": shape,
            "$dim": dimension
          }
        }
      );  
    }
  }


  // init ForceDirected
  var fd = new $jit.ForceDirected( {
    //id of the visualization container
    injectInto: 'infovis',
    //Enable zooming and panning by scrolling and DnD
    Navigation: {
      enable: true,
      //Enable panning events only if we're dragging the empty canvas (and not a node).
      panning: 'avoid nodes',
      zooming: 50 //zoom speed. higher is more sensible
    },
    // Change node and edge styles such as color and width.
    // These properties are also set per node with dollar prefixed data-properties in the JSON structure.
    Node: {
      overridable: true
    },
    //Native canvas text styling
    Label: {
      type: labelType, //Native or HTML
      size: 12
    },
    //Add Tips
    Tips: {
      enable: true,
      onShow: function(tip, node) {
        //display node info in tooltip
        var interest_name;
        for (var i = 0; i < interests.length; i++) {
          if (interests[i]['short_name'] == node.name) {
            interest_name = interests[i]['name']
            break;
          }
        }
        tip.innerHTML = "<div class=\"tip-title\">" + interest_name + "</div>";
      }
    },
    // Add node events
    Events: {
      enable: true,
      type: 'Native',
      //Change cursor style when hovering a node
      onMouseEnter: function() {
        fd.canvas.getElement().style.cursor = 'pointer';
      },
      onMouseLeave: function() {
        fd.canvas.getElement().style.cursor = '';
      },
      //Add also a click handler to nodes
      onClick: function(node) {
        if(!node) return;
        // Load proper page if node clicked
        var url = document.URL.split('#')[0];
        window.location.href = url + "?interest_area=" + node.name + "#focus_graph";
      }
    },
    //Number of iterations for the FD algorithm
    iterations: 200,
    //Edge length
    levelDistance: 400,
  });

  // load JSON data.
  fd.loadJSON(json);

  // compute positions incrementally and animate.
  fd.computeIncremental( {
    iter: 40,
    property: 'end',
    onStep: function(perc) {
      Log.write(perc + '% loaded...');
    },
    onComplete: function() {
      Log.write('');
      fd.animate({
        modes: ['linear'],
        transition: $jit.Trans.Elastic.easeOut,
        duration: 1500
      });
    }
  });
}
