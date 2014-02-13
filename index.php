<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<style>
			body {
				background-color: #ffffff;
				margin: auto;
				overflow: hidden;
			}
			.main {
			margin:auto;
			padding:20px 20px;
			}

		</style>
	
	</head>
	<body>

		<script src="../build/three.min.js"></script>
		<script src="js/controls/TrackballControls.js"></script>
        <script src="js/controls/RollControls.js"></script>
	<?php

    $u_agent = $_SERVER['HTTP_USER_AGENT'];
   
    if(preg_match('/MSIE/i',$u_agent))
    {
       $radius= 200;
	   $btexture = 30;
	   $stexture = 20;
	   $refreshbtn=172; 
    }
    else 
	{
	  $radius= 200;
	     $btexture = 50;
	   $stexture =40;
	    $refreshbtn=195;
	}


?>
   <div class="main" >
     <div  style="position:absolute;top:10px;right:60px;">
	<input style="float:left; width:70px;height:30px;" type="button" id="btn1" value="zoom +"  />
	<input style="float:left;margin-left:10px;width:70px;height:30px;" type="button" id="btn2" value="zoom -"/>
	</div>
	<div  style="position:absolute;top:10px;left:60px;">
	<input style="width:70px;height:40px;" type="button" id="btnstop" value="stop"  /><br/>

	</div>


		<script>
          
			var camera, scene, renderer;
			var geometry, material, mesh;
            var INTERSECTED, aspect, projector;
			var scene2, renderer2;
            var objects = [];
			var objects1 = [];
		    var objects2 = [];
			var objects3 = [];
			var objects4 = [];
			var controls,controls1;
            var clock = new THREE.Clock();
			init();
			animate();
		

			function init() {
			
			    // set camera view and controls values

				camera = new THREE.PerspectiveCamera( 120, window.innerWidth / window.innerHeight, 1, 1000 );
				camera.position.set( 200, 100, 200 );

				controls = new THREE.TrackballControls( camera );
	             
	
	            controls.movementSpeed = 100;
				controls.lookSpeed = 3;
				controls.constrainVertical = [ 0, 0 ];
				
				controls.rotateSpeed = 0.05;
				controls.zoomSpeed = 0.5;
			//	controls.panSpeed = 0.8;

				controls.noZoom = false;
				controls.noPan = false;

				controls.staticMoving = false;
		//		controls.dynamicDampingFactor = 0.1;

				controls.keys = [ 65, 83, 68 ];
				
				controls1 = new THREE.RollControls( camera );

				controls1.movementSpeed = 100;
				controls1.lookSpeed = 3;
				controls1.constrainVertical = [ 0, 0 ];

				scene = new THREE.Scene();
			
			    // texture for sphere
	            var earthTexture = new THREE.Texture();
				var loader = new THREE.ImageLoader();

				loader.addEventListener( 'load', function ( event ) {

					earthTexture.image = event.content;
					earthTexture.needsUpdate = true;

				} );

				loader.load( 'textures/envmap.png' );
				
				// making sphere
				geometry = new THREE.SphereGeometry( <?php echo $radius; ?> , <?php echo $btexture; ?>, <?php echo $btexture; ?> );
				material = new THREE.MeshBasicMaterial( { map: earthTexture, overdraw: true} );

				mesh = new THREE.Mesh( geometry, material );
				scene.add( mesh );

				renderer = new THREE.CanvasRenderer();
				renderer.setSize( window.innerWidth, window.innerHeight );
				document.body.appendChild( renderer.domElement );

	
				   
				   var plane = new THREE.Mesh(geometry, material);
				   
				      //Background Texture
                var backgroundTexture = THREE.ImageUtils.loadTexture('imgs/');
                var backgroundGeo = new THREE.PlaneGeometry(600, 600);
                var backgroundMat = new THREE.MeshBasicMaterial({map: backgroundTexture});
                var backgroundPlane = new THREE.Mesh(backgroundGeo, backgroundMat);
                backgroundPlane.position.z = -1000;
                backgroundPlane.overdraw = true;
				 
               //ball1		
				   
                var galleryTexture = makeTextTexture("<?php $file = file_get_contents('name1.txt', true); $file = explode (',',$file); echo $file[0]; ?>", 1900, 900, '80pt Helvetica', 'white', "left", "", "<?php $file = file_get_contents('name1.txt', true); $file = explode (',',$file); echo $file[2]; ?>");
                var galleryGeom = new THREE.SphereGeometry( <?php $file = file_get_contents('name1.txt', true); $file = explode (',',$file); echo $file[1]; ?>, <?php echo $stexture; ?>, <?php echo $stexture; ?> );
                var galleryMaterial = new THREE.MeshBasicMaterial({map: galleryTexture, overdraw:true});
                var galleryTest = new THREE.Mesh(galleryGeom, galleryMaterial);
                galleryTest.position.x = 90; 
                galleryTest.position.y = 90;
                galleryTest.position.z = 135;
                galleryTest.castShadow = true;
				
				
				//ball2
				  var galleryTexture1 = makeTextTexture("<?php $file = file_get_contents('name2.txt', true); $file = explode (',',$file); echo $file[0]; ?>", 1900, 900, '80pt Helvetica', 'white', "left", "", "<?php $file = file_get_contents('name2.txt', true); $file = explode (',',$file); echo $file[2]; ?>");
                var galleryGeom1 = new THREE.SphereGeometry( <?php $file = file_get_contents('name2.txt', true); $file = explode (',',$file); echo $file[1]; ?>, <?php echo $stexture; ?>, <?php echo $stexture; ?>);
                var galleryMaterial1 = new THREE.MeshBasicMaterial({map: galleryTexture1, overdraw:true});
                var galleryTest1 = new THREE.Mesh(galleryGeom1, galleryMaterial1);
                galleryTest1.position.x = 150; 
                galleryTest1.position.y = 90;
                galleryTest1.position.z = 70;
                galleryTest1.castShadow = true;
				
				
				//ball3
					  var galleryTexture2 = makeTextTexture("<?php $file = file_get_contents('name3.txt', true); $file = explode (',',$file); echo $file[0]; ?>", 1900, 900, '80pt Helvetica', 'white', "left", "", "<?php $file = file_get_contents('name3.txt', true); $file = explode (',',$file); echo $file[2]; ?>");
                var galleryGeom2 = new THREE.SphereGeometry( <?php $file = file_get_contents('name3.txt', true); $file = explode (',',$file); echo $file[1]; ?>, <?php echo $stexture; ?>, <?php echo $stexture; ?> );
                var galleryMaterial2 = new THREE.MeshBasicMaterial({map: galleryTexture2, overdraw:true});
                var galleryTest2 = new THREE.Mesh(galleryGeom2, galleryMaterial2);
                galleryTest2.position.x = 110; 
                galleryTest2.position.y = 40;
                galleryTest2.position.z = 150;
                galleryTest2.castShadow = true;
				
				
				//ball4
					  var galleryTexture3 = makeTextTexture("<?php $file = file_get_contents('name4.txt', true); $file = explode (',',$file); echo $file[0]; ?>", 1900, 900, '80pt Helvetica', 'white', "left", "", "<?php $file = file_get_contents('name4.txt', true); $file = explode (',',$file); echo $file[2]; ?>");
                var galleryGeom3 = new THREE.SphereGeometry( <?php $file = file_get_contents('name4.txt', true); $file = explode (',',$file); echo $file[1]; ?>, <?php echo $stexture; ?>, <?php echo $stexture; ?>);
                var galleryMaterial3 = new THREE.MeshBasicMaterial({map: galleryTexture3,overdraw:true});
                var galleryTest3 = new THREE.Mesh(galleryGeom3, galleryMaterial3);
                galleryTest3.position.x = 100; 
                galleryTest3.position.y = 120;
                galleryTest3.position.z = 100;
                galleryTest3.castShadow = true;
				
				//ball5
					  var galleryTexture4 = makeTextTexture1("<?php $file = file_get_contents('name5.txt', true); $file = explode (',',$file); echo $file[0]; ?>",1900, 900, '80pt Helvetica', 'white', "right", "", "<?php $file = file_get_contents('name5.txt', true); $file = explode (',',$file); echo $file[2]; ?>");
                var galleryGeom4 = new THREE.SphereGeometry( <?php $file = file_get_contents('name5.txt', true); $file = explode (',',$file); echo $file[1]; ?>, <?php echo $stexture; ?>, <?php echo $stexture; ?> );
                var galleryMaterial4 = new THREE.MeshBasicMaterial({map: galleryTexture4, overdraw:true});
                var galleryTest4= new THREE.Mesh(galleryGeom4, galleryMaterial4);
                galleryTest4.position.x = 115; 
                galleryTest4.position.y = 50;
                galleryTest4.position.z = - 150;
                galleryTest4.castShadow = true;
				
				
				//
				         //Adds an event listener to the webpage that "listens" for mouse movements and when the mouse does move, it runs the 
                //"onMouseMove" function
                document.addEventListener('mousemove', onMouseMove, false);

              

                document.addEventListener('mousedown', onDocumentMouseDown, false);
				projector = new THREE.Projector();
				scene.add(galleryTest);
				scene.add(galleryTest1);
				scene.add(galleryTest2);
				scene.add(galleryTest3);
				scene.add(galleryTest4);

				  	objects.push( galleryTest);
					objects1.push( galleryTest1);
					objects2.push( galleryTest2);
					objects3.push( galleryTest3);
					objects4.push( galleryTest4);
         
			}

			   function onMouseMove(event) {
                mouseX = event.clientX;
                mouseY = event.clientY;
            }
			 function onDocumentMouseDown(event) {
              //  event.preventDefault();

                var vector = new THREE.Vector3(
                    ( event.clientX / window.innerWidth ) * 2 - 1,
                  - ( event.clientY / window.innerHeight ) * 2 + 1,
                    0.5
                );
                projector.unprojectVector( vector, camera );

                var ray = new THREE.Ray( camera.position, 
                                         vector.subSelf( camera.position ).normalize() );

                var intersects = ray.intersectObjects( objects );
				var intersects1 = ray.intersectObjects( objects1 );
				var intersects2 = ray.intersectObjects( objects2);
				var intersects3 = ray.intersectObjects( objects3);
				var intersects4 = ray.intersectObjects( objects4);

                if ( intersects.length > 0 ) {

         camera.position.set( 150, 100, 240 ); 
		  document.getElementById('form1').style.visibility="visible"; 
		  document.getElementById('form2').style.visibility="hidden";
		  document.getElementById('form3').style.visibility="hidden";
		  document.getElementById('form4').style.visibility="hidden";
		  document.getElementById('form5').style.visibility="hidden";
		  document.getElementById('refresh').style.visibility="visible";		  

                }
				  if ( intersects1.length > 0 ) {

          camera.position.set( 255, 100, 103 ); 
		  document.getElementById('form1').style.visibility="hidden"; 
		  document.getElementById('form2').style.visibility="visible";
		  document.getElementById('form3').style.visibility="hidden";
		  document.getElementById('form4').style.visibility="hidden";
		  document.getElementById('form5').style.visibility="hidden";
		  document.getElementById('refresh').style.visibility="visible";		  

		 }
						  if ( intersects2.length > 0 ) {

         camera.position.set( 170, 70, 230 ); 
	      document.getElementById('form1').style.visibility="hidden"; 
		  document.getElementById('form2').style.visibility="hidden";
		  document.getElementById('form3').style.visibility="visible";
		  document.getElementById('form4').style.visibility="hidden";
		  document.getElementById('form5').style.visibility="hidden";
          document.getElementById('refresh').style.visibility="visible";		  
		  
		 }
		 				  if ( intersects3.length > 0 ) {

         camera.position.set( 190, 140, 190 ); 
	      document.getElementById('form1').style.visibility="hidden"; 
		  document.getElementById('form2').style.visibility="hidden";
		  document.getElementById('form3').style.visibility="hidden";
		  document.getElementById('form4').style.visibility="visible";
		  document.getElementById('form5').style.visibility="hidden";
          document.getElementById('refresh').style.visibility="visible";		  
		  
		 }
		  				  if ( intersects4.length > 0 ) {

         camera.position.set( 190, 90, -250 ); 
          document.getElementById('form1').style.visibility="hidden"; 
		  document.getElementById('form2').style.visibility="hidden";
		  document.getElementById('form3').style.visibility="hidden";
		  document.getElementById('form4').style.visibility="hidden";
		  document.getElementById('form5').style.visibility="visible";	
         document.getElementById('refresh').style.visibility="visible";		  
		 }

            }
			
			  function makeTextTexture(text, width, height, font, fillStyle, textAlign, textBaseline, backgroundColor)
            {
                //Makes a new canvas element
                var bitmap = document.createElement('canvas');

                //Gets its 2d css element
                var g = bitmap.getContext('2d');

                //Sets it's width and height
                bitmap.width = width;
                bitmap.height = height;

                //Takes "g", it's 2d css context and set's all of the following
                g.font = font;

                g.fillStyle = backgroundColor;
                g.fillRect(0, 0, width, height);

                g.textAlign = "right";
                g.textBaseline = "bottom";
                g.fillStyle = fillStyle;
                g.fillText(text, width / 2, height / 2);

                //Rendered the contents of the canvas to a texture and then returns it
                var texture = new THREE.Texture(bitmap);
                texture.needsUpdate = true;

                return texture;
            }
			
				  function makeTextTexture1(text, width, height, font, fillStyle, textAlign, textBaseline, backgroundColor)
            {
                //Makes a new canvas element
                var bitmap = document.createElement('canvas');

                //Gets its 2d css element
                var g = bitmap.getContext('2d');

                //Sets it's width and height
                bitmap.width = width;
                bitmap.height = height;

                //Takes "g", it's 2d css context and set's all of the following
                g.font = font;

                g.fillStyle = backgroundColor;
                g.fillRect(0, 0, width, height);

                g.textAlign = "left";
                g.textBaseline = "bottom";
                g.fillStyle = fillStyle;
                g.fillText(text, width / 2, height / 2);

                //Rendered the contents of the canvas to a texture and then returns it
                var texture = new THREE.Texture(bitmap);
                texture.needsUpdate = true;

                return texture;
            }
			function animate() {

				requestAnimationFrame( animate );
                controls1.update( clock.getDelta() );
				controls.update();

				renderer.render( scene, camera );
				renderer2.render( scene2, camera );

			}

		</script>

		<iframe id="form1" style="position:absolute;top:60px;right:10px;height:200px;width:200px;border:none;outline:none;visibility:hidden;" src="b1.php"></iframe>
		<iframe id="form2" style="position:absolute;top:60px;right:10px;height:200px;width:200px;border:none;outline:none;visibility:hidden;" src="b2.php"></iframe>
		<iframe id="form3" style="position:absolute;top:60px;right:10px;height:200px;width:200px;border:none;outline:none;visibility:hidden;" src="b3.php"></iframe>
		<iframe id="form4" style="position:absolute;top:60px;right:10px;height:200px;width:200px;border:none;outline:none;visibility:hidden;" src="b4.php"></iframe>
		<iframe id="form5" style="position:absolute;top:60px;right:10px;height:200px;width:200px;border:none;outline:none;visibility:hidden;" src="b5.php"></iframe>
		<form id="refresh" style="position:absolute;top:<?php echo $refreshbtn; ?>px;right:30px;visibility:hidden;" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="submit" value="Refresh"/>
		</form>
</div>
	</body>
</html>
