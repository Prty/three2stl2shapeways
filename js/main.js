var camera, scene, renderer;
var geometry, material, mesh;

init();
animate();

function init() {
	camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 10000 );
	camera.position.z = 1000;
	scene = new THREE.Scene();
	//geometry = new THREE.TetrahedronGeometry( 200 );
	geometry = new THREE.CubeGeometry( 200, 200, 200 );
	material = new THREE.MeshBasicMaterial( { color: 0xff0000, wireframe: true } );

	mesh = new THREE.Mesh( geometry, material );
	scene.add( mesh );

	renderer = new THREE.CanvasRenderer();
	renderer.setSize( window.innerWidth, window.innerHeight );

	document.body.appendChild( renderer.domElement );

	//
	// this is where the exporting happens
	//

	
	// this code exports into stl the same as above but also downloads the file
	//console.log( stlFromGeometry( geometry, {download:true} ) )
}
function makeStl(){
	console.log("fun");
	var stlObjectExported = stlFromGeometry( geometry, {download: false} );
	//console.log(stlObjectExported);
	$.post(
        'http://www.shiroari.com/3dtweet/php/post.php',{
          'stl': stlObjectExported
        },function(data){
          alert(data);
        }
      );
}

function animate() {
	// note: three.js includes requestAnimationFrame shim
	requestAnimationFrame( animate );

	mesh.rotation.x += 0.01;
	mesh.rotation.y += 0.02;

	renderer.render( scene, camera );

}