<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	
	<title>CS CONNECT</title>
	
</head>

<body>

	{{-- Top Navigation Bar --}}
	
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container" style="width: 970px !important">
      
        <div class="navbar-header">
        	<a class="navbar-brand" href="#">CS CONNECT</a>
        </div>
        
        <div class="navbar-collapse collapse">
        	
        	<ul class="nav navbar-nav">
            	<li><a href="#">Messages</a></li>
				<li><a href="#">Notifications</a></li>
			</ul>
          
			<ul class="nav navbar-nav navbar-right">
            	<li><a href="{{ URL::to('logout') }}">Logout</a></li>
			</ul>
			
        </div>
        
		</div>
	</div>
	
	{{-- Main Content Container --}}
	
	<div class="container" style="padding-top: 70px; max-width: none !important; width: 970px">
	
		<div class="row">
			
			<div class="col-xs-3">
				<div class="affix">
					<p>sup breh </p>
					<p>{{ $user->first }} {{ $user->last }}</p>
					<p>{{ $user->email }}</p>
					<p>mini profile view</p>
					<ul class="nav">
						<li><a href="#">Hello</a></li>
						<li><a href="#">World</a></li>
						<li><a href="#">Again</a></li>
						<li><a href="#">Two</a></li>
					</ul>
				</div>
			</div>
			
			<div class="col-xs-9">
			
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent rhoncus euismod eleifend. Integer lacinia leo leo. Cras facilisis felis sem, pulvinar eleifend nibh fermentum a. Suspendisse iaculis purus ut urna aliquam, sit amet molestie risus ultrices. Mauris auctor erat enim, ultrices venenatis velit blandit eu. Phasellus commodo libero vitae egestas condimentum. Nunc feugiat cursus lacus, id malesuada purus accumsan sed. Donec euismod, turpis ornare vulputate dictum, metus tortor sodales nulla, vel dapibus risus lorem eget quam. Vivamus facilisis condimentum condimentum. Phasellus venenatis egestas dapibus. Phasellus congue, odio id euismod consectetur, erat urna ornare diam, pulvinar eleifend nisl justo vel diam. Morbi laoreet erat ac nisl dictum, sed pellentesque ligula ornare.<br>
			<br>
			Donec orci urna, lobortis a enim vel, mollis accumsan dui. Ut pulvinar eu leo eu posuere. Quisque mi massa, suscipit a lacus ut, hendrerit volutpat orci. Sed et scelerisque urna. Nulla pharetra nibh et odio dignissim, in egestas sapien lobortis. Nullam volutpat varius ante a eleifend. Praesent sem nunc, ultrices volutpat interdum nec, adipiscing nec dui. In eu leo ipsum. Donec congue in nunc eget iaculis. Nunc posuere nisl augue, sit amet molestie lectus porta non. Morbi euismod dui nunc, et rhoncus turpis varius sit amet. Maecenas tincidunt aliquam hendrerit. Integer eget ipsum diam. Quisque faucibus cursus enim, quis imperdiet justo iaculis ac.<br>
			<br>
			In luctus felis elementum magna posuere, non semper metus facilisis. Integer et justo vel elit fringilla tempus et sed tortor. Fusce ut consectetur odio. Donec placerat magna eu vulputate viverra. Duis ultrices nisi non justo imperdiet, vitae aliquam magna condimentum. Proin quis luctus neque. Nulla enim purus, varius ultricies elementum id, placerat nec arcu.<br>
			<br>
			Quisque id varius lacus, eu pellentesque dolor. Pellentesque libero purus, cursus placerat consequat sit amet, iaculis non tellus. Mauris sit amet mi nibh. Mauris non nulla diam. Aliquam ut feugiat felis. Donec mollis urna vitae elit accumsan, at tincidunt metus dapibus. Quisque risus dolor, mollis vitae suscipit id, venenatis id arcu. Donec laoreet quam in libero dapibus, sit amet elementum lectus adipiscing. Nunc quis lectus vehicula, euismod ante ac, porttitor quam.<br>
			<br>
			Aenean lobortis enim sit amet augue vulputate pharetra. Aliquam venenatis faucibus suscipit. Aenean cursus velit nibh, sed lobortis massa scelerisque vitae. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut libero odio, ullamcorper ac orci quis, aliquam pretium ligula. Nulla vulputate eu augue sed vulputate. Aliquam rutrum, massa ac vehicula tristique, dui massa luctus augue, ut molestie ligula leo sed dolor. Pellentesque interdum quam et est commodo scelerisque.<br>
			<br>
			Integer lectus enim, ullamcorper vel aliquam ut, laoreet in tortor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent eget felis malesuada, mollis velit malesuada, viverra ipsum. Duis tincidunt non felis eget elementum. Donec fermentum velit eget tempor sagittis. Quisque lacinia odio ac purus commodo, at mollis felis volutpat. Vivamus cursus varius velit, et interdum risus laoreet eget.<br>
			<br>
			In auctor congue magna, eu sagittis dolor viverra non. Mauris non dui nec nisl feugiat cursus ut nec lectus. Pellentesque vitae purus mollis, congue lectus sit amet, scelerisque felis. Etiam aliquet elit sit amet tristique semper. Nulla tellus massa, porttitor nec est at, tincidunt imperdiet augue. Ut sodales pretium pretium. Vivamus urna lectus, dictum vestibulum nisi non, rhoncus gravida sapien. Maecenas sed magna quis ligula semper faucibus vel vel enim. Aliquam erat volutpat.<br>
			<br>
			Mauris fermentum ut risus at cursus. Suspendisse potenti. Vestibulum ipsum libero, vestibulum sit amet odio id, ultricies eleifend risus. Donec viverra justo bibendum dignissim pharetra. In hendrerit enim sed elit porttitor, vitae rutrum velit pretium. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas commodo neque urna, id placerat metus pellentesque vel.<br>
			<br>
			Donec consequat lorem nec congue pulvinar. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque vulputate malesuada libero ac convallis. Donec tristique ultrices dui, ut laoreet tellus pharetra eget. Nulla in elit urna. Sed feugiat quis nibh ut blandit. Fusce dapibus ante vel aliquam suscipit. Morbi eleifend neque sit amet justo scelerisque adipiscing. Cras dui nisi, dapibus in lorem vitae, ornare eleifend lacus. Maecenas nec pharetra dolor.<br>
			<br>Nulla mattis sit amet ligula ac hendrerit. Nunc eu urna molestie, convallis erat vel, vulputate erat. Praesent et sodales massa, id sollicitudin urna. Pellentesque id ipsum arcu. Vivamus lorem erat, accumsan eu pellentesque et, sollicitudin et sapien. Vestibulum sed laoreet justo, et blandit est. Donec rutrum sit amet urna id tempor. Nunc sollicitudin lacus id libero accumsan dictum. Mauris vitae enim ut lacus pulvinar aliquam. Suspendisse feugiat orci ac ullamcorper blandit. Phasellus suscipit est mauris, sit amet pharetra nisl convallis eget. Nam placerat, risus vitae hendrerit tempor, tellus nibh vehicula dolor, eu euismod arcu erat eget nulla. Morbi convallis felis diam, nec mollis augue accumsan non. Praesent adipiscing convallis libero vel sodales. Phasellus id felis neque. Donec varius tempus lobortis.<br>
			<br>
			Fusce suscipit nec justo imperdiet accumsan. Morbi eu nulla id ligula vulputate tincidunt vehicula in magna. Ut tempus nibh mi, ac faucibus enim feugiat non. Pellentesque ut blandit nisi, sit amet egestas est. Donec non vestibulum velit. Cras accumsan, mauris id convallis lobortis, odio enim rhoncus justo, vel pulvinar mauris leo in diam. Ut lobortis nisl et purus dignissim aliquet. Curabitur adipiscing id lorem vel mattis. Suspendisse non lectus orci. Morbi nec nibh felis.<br>
			<br>
			In cursus justo nec consectetur scelerisque. Mauris vitae odio a tellus mattis aliquet ac nec ante. Integer luctus tempus purus, at imperdiet nisl. Ut mauris leo, aliquam ut consectetur hendrerit, blandit sit amet eros. Nulla fermentum dictum vulputate. Maecenas et facilisis diam. Fusce quis venenatis magna. Donec ac rutrum sem. Sed lacinia lobortis commodo. Nullam eget ipsum bibendum, hendrerit nisl non, facilisis justo. Aenean imperdiet magna sit amet metus molestie, quis tincidunt leo auctor. Donec ullamcorper iaculis magna. Fusce ornare non leo ac bibendum. Pellentesque viverra iaculis augue, vitae pretium neque pellentesque et. Phasellus quis ligula vel nulla blandit pretium a nec sem. Vestibulum nibh diam, venenatis hendrerit enim vel, porta varius augue.<br>
			<br>
			Nunc iaculis dui nec blandit sollicitudin. Donec at augue mollis, tempus elit vel, adipiscing est. Duis nunc turpis, tempus quis purus sit amet, elementum bibendum dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In porttitor aliquet augue non ullamcorper. In imperdiet vel eros ut convallis. Nullam id auctor orci. Nunc facilisis, nisl ac gravida viverra, metus purus porta erat, adipiscing convallis ligula massa eu enim. Integer mauris lectus, posuere at ultrices vitae, ornare ac nisi.<br>
			<br>
			Phasellus laoreet porttitor leo. Vivamus sodales venenatis nisi, ac euismod ante blandit quis. Ut sollicitudin arcu at metus accumsan, ullamcorper luctus nulla fringilla. Duis quam leo, porta et consectetur eu, congue venenatis magna. Quisque auctor iaculis arcu gravida fermentum. Aenean pretium iaculis viverra. Cras lacus mauris, pulvinar sit amet tempus id, accumsan vel dui. Aliquam lobortis vehicula ultrices. Vestibulum interdum posuere nunc, vitae condimentum mi suscipit ultrices.<br>
			<br>
			Donec fringilla diam odio, bibendum condimentum odio adipiscing eget. Aliquam id massa imperdiet, ornare felis vitae, faucibus sem. Aenean vel neque porttitor, tincidunt massa cursus, ultrices diam. Donec hendrerit augue neque, nec viverra purus interdum sed. Aliquam bibendum vehicula venenatis. Morbi gravida orci id commodo interdum. Sed pulvinar arcu fermentum, accumsan felis ac, elementum tortor. Curabitur hendrerit sollicitudin velit a ultrices. Duis vehicula eget ante in imperdiet. Praesent vitae viverra diam. Mauris pulvinar rutrum venenatis.<br>
			<br>
			Integer egestas placerat pharetra. Vestibulum egestas erat a leo lobortis, et porttitor justo egestas. Nulla adipiscing mauris sit amet magna ullamcorper, sit amet tincidunt justo luctus. Curabitur ante justo, eleifend in lacus ac, elementum mollis est. Praesent facilisis bibendum semper. Vestibulum rutrum, dolor non bibendum tempor, nunc erat viverra lacus, sit amet mollis dolor lorem in elit. Morbi id nisi vel ligula ornare gravida. Suspendisse pharetra egestas suscipit. Ut nisl elit, cursus quis enim in, consectetur pulvinar nulla. Proin non quam turpis. Praesent id sollicitudin elit. Nam purus tortor, posuere vel congue ac, molestie sit amet ipsum. Etiam est sapien, elementum consequat risus sit amet, semper faucibus nisi. Sed massa tortor, mollis non ligula id, bibendum convallis lacus. Nullam lacinia erat ultrices, cursus est vel, condimentum est.<br>
			<br>
			Nullam vel gravida lorem. Integer laoreet sed est sed venenatis. Curabitur risus mi, vehicula id mollis ut, aliquet id tellus. Donec eget justo at nunc ullamcorper congue. Suspendisse adipiscing leo nec odio auctor faucibus. Nulla laoreet tempus fermentum. Praesent pharetra eros nibh, et porttitor nisl consectetur ut. Vestibulum at mollis lorem. Phasellus a sollicitudin urna.<br>
			<br>
			Nam consequat lacinia pellentesque. Praesent pulvinar dui quis mollis mattis. Vivamus rhoncus, dui eget varius luctus, nunc augue sagittis enim, a eleifend leo dolor et ante. Suspendisse rutrum augue sit amet risus ultrices dignissim. Vestibulum rutrum sed sem a molestie. In ultrices arcu consequat pharetra scelerisque. Cras vestibulum purus nec nisl consectetur, sit amet viverra arcu interdum. In bibendum tempor dapibus. Suspendisse feugiat dapibus egestas. Aliquam non varius enim.<br>
			<br>
			In in tortor sit amet ipsum condimentum ultrices nec non orci. Praesent sit amet consequat lacus. Quisque non libero pellentesque, vulputate nisl vel, dapibus felis. Maecenas mollis justo nec elit laoreet, commodo viverra arcu aliquam. Sed pellentesque mauris eros, a luctus arcu feugiat non. Cras in quam nulla. Maecenas posuere odio mattis quam porttitor, id fringilla quam euismod. Sed ultrices vestibulum pretium. Vivamus vehicula diam ut est lacinia, sed sagittis mauris blandit. Fusce sed magna felis. Duis sodales enim augue, id pretium dolor interdum vitae. Aenean posuere, velit at euismod placerat, magna magna consequat nibh, nec dictum quam nisi et ligula. Nulla mattis facilisis nibh a tristique. Morbi eu rutrum sapien. Praesent posuere ullamcorper ante ac porttitor.<br>
			<br>
			Sed vulputate erat ut sodales mollis. Curabitur dignissim eleifend libero, eu suscipit ante rutrum id. Integer sagittis urna vitae magna hendrerit, eget adipiscing risus cursus. Duis ac rhoncus turpis. Quisque ultricies rhoncus cursus. Morbi dapibus neque sed turpis egestas commodo. Sed dui ligula, suscipit et lorem ac, placerat elementum nisl. Proin luctus sodales nisl, vel sodales massa ultricies ut. Nam tincidunt pretium augue sed posuere. Phasellus faucibus neque sapien, eu tristique leo fermentum at. Sed eu consequat nisi. Pellentesque venenatis neque id massa iaculis, non vehicula dolor mollis.</p>
			</div>
			
		</div>
	
	</div>

{{--

	<h1>sup {{ $user->first }} {{ $user->last }}</h1>
	<p>your email: {{ $user->email }}</p>

	<a href="{{ URL::to('logout') }}">Click here to logout!</a> --}}
	


	
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
	{{ HTML::script('assets/js/bootstrap.min.js') }}

</body>
</html>