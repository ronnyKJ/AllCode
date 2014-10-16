

/**
 * 
 */
function Visualize() {
	
	// The *current* size of the display area
	var WIDTH = window.innerWidth;
	var HEIGHT = window.innerHeight;
	
	this.DISPLAY_PIPE = 'pipe';
	this.DISPLAY_CONE = 'cone';
	this.DISPLAY_CIRCLE = 'circle';
	this.DISPLAY_SPIRAL = 'spiral';
	this.DISPLAY_SWIRL = 'swirl';
	
	var displayMode = this.DISPLAY_PIPE;
	
	var context, canvas;
	
	// The current position of the mouse
	var mouse = {x:0,y:0};
	
	// Flags if the mouse is currently pressed down
	var mouseIsDown = false;
	
	var points = [];
	
	var SCENE_DEPTH = -10; // -100 (furthest back) to n (furthest front)
	var SCENE_VP = {x: WIDTH * .5, y: HEIGHT * .5}; // Vanishing point
	var SCENE_VPSO = {x: 1.0, y: 1.0}; // Vanishing point scale offset
	
	/**
	 * Constructor.
	 */
	this.Initialize = function( canvasID ) {
		canvas = document.getElementById( canvasID );
		
		if (canvas && canvas.getContext) {
			context = canvas.getContext('2d');
			
			// Register event listeners
			$(canvas).mousemove(MouseMove);
			$(canvas).mousedown(MouseDown);
			$(canvas).mouseup(MouseUp);
			$(window).resize(Resize);
			
			var len = 300;
			for( var i = 0; i < len; i++ ) {
				points.push( { x: 0, y: 0, size: i / len * 10 } );
			}
			
			this.SetDisplayMode( displayMode );
			
			// Force an initial resize
			Resize();
			
			setInterval( Step, 40 );
			
		}
	};
	
	/**
	 * 
	 */
	this.SetDisplayMode = function( mode ) {
		
		displayMode = mode;
		
		var radius = 200;
		
		var x = (WIDTH*.5)-radius;
		var y = (HEIGHT*.5)-radius;
		var z = 10;
		
		var len = points.length;
		
		for( var i = 0; i < len; i++ ) {
			points[i].x = points[i].x ? points[i].x : 0;
			points[i].y = points[i].y ? points[i].y : 0;
			points[i].z = points[i].z ? points[i].z : 0;
			
			z = i / len * 4;
			
			switch( displayMode ) {
				case this.DISPLAY_CIRCLE:
					x = (WIDTH*.5)+Math.cos( (i / len) * Math.PI * 2 ) * radius;
					y = (HEIGHT*.5)+Math.sin( (i / len) * Math.PI * 2 ) * radius;
					break;
				case this.DISPLAY_PIPE:
					x = (WIDTH*.5)+Math.cos( (i / (len*.5)) * radius ) * radius;
					y = (HEIGHT*.5)+Math.sin( (i / (len*.5)) * radius ) * radius;
					z = Math.cos( (i / (len*.5) ) ) * 5;
					break;
				case this.DISPLAY_CONE:
					x = (WIDTH*.5)+Math.cos( (i / (len*.1)) * radius ) * ((len-(i*.6))/len)*radius;
					y = (HEIGHT*.5)+Math.sin( (i / (len*.1)) * radius ) * ((len-(i*.6))/len)*radius;
					break;
				case this.DISPLAY_SPIRAL:
					x = (WIDTH*.5)+Math.cos( (i / (len*.3)) * Math.PI * 2 ) * (radius*(i / len));
					y = (HEIGHT*.5)+Math.sin( (i / (len*.3)) * Math.PI * 2 ) * (radius*(i / len));
					break;
				case this.DISPLAY_SWIRL:
					x = (WIDTH*.5)+Math.cos( (i / (points.length*.1)) * Math.PI * 2 ) * (radius*(i / points.length));
					y = (HEIGHT*.5)+Math.sin( (i / (points.length*.1)) * Math.PI * 2 ) * (radius*(i / points.length));
					break;
				default:
					x += 20;
					if( x > (WIDTH*.5)+radius ) {
						x = (WIDTH*.5)-radius;
						y += 20;
					}
			}
			
			$(points[i]).animate( { x: x, y: y, z: z }, 400, "linear");
			
		}
	};
	
	/**
	 * 
	 */
	function Step() {
		
		
		var vpox = ( mouse.x - WIDTH * .5 ) * 1.2;
		var vpoy = ( mouse.y - HEIGHT * .5 ) * 1.2;
		
//		SCENE_VP.x = (WIDTH * .5)+vpox;
//		SCENE_VP.y = (HEIGHT * .5)+vpoy;
		
		$(SCENE_VP).stop().animate( { x: (WIDTH * .5)+vpox, y: (HEIGHT * .5)+vpoy }, 200, "linear");
		
		Render();
	}
	
	/**
	 * Renders the current state of the display.
	 */
	function Render() {
		
		if( points ) {
			context.clearRect( 0, 0, WIDTH, HEIGHT );
			
			context.beginPath();
			context.fillStyle = "#000000";
			context.strokeStyle = "#000000";
			
			for( var i = points.length - 1; i >= 0; i-- ) {
				
//				context.moveTo(points[i].x,points[i].y); // needed in ff
//				context.arc(points[i].x,points[i].y,points[i].size,0,Math.PI*2,true);
				
				var instructions = points[i];
				
				var particle = {};
				
				// Determine position and adapt to vanishing point depending on depth
				particle.x = instructions.x + ( instructions.x - SCENE_VP.x  ) * ( ( instructions.z / SCENE_DEPTH ) / SCENE_VPSO.x );
				particle.y = instructions.y + ( instructions.y - SCENE_VP.y ) * ( ( instructions.z / SCENE_DEPTH ) / SCENE_VPSO.y );
				
//				particle.x += WIDTH*.5;
//				particle.y += HEIGHT*.5;
				
				// Determine scale based on z and size based on scale
				particle.scale = ( instructions.z / SCENE_DEPTH ) + 1;
				particle.size = instructions.size * particle.scale;
				
				context.moveTo(particle.x, particle.y);
				context.arc(particle.x, particle.y, particle.size, 0, Math.PI*2, true);
				
			}
			
			context.fill();
			context.closePath();
		}
	}
	
	/**
	 * Mouse event handlers
	 */
	function MouseMove(e) {
		mouse.x = e.layerX;
		mouse.y = e.layerY;
		
	}
	function MouseDown(e) {
		mouseIsDown = true;
	}
	function MouseUp(e) {
		mouseIsDown = false;
	}
	
	/**
	 * 
	 */
	function Resize() {
		WIDTH = window.innerWidth;
		HEIGHT = window.innerHeight;
		
		canvas.width = WIDTH;
		canvas.height = HEIGHT;
	}
	
	function DistanceBetween(p1,p2) {
		var dx = p2.x-p1.x;
		var dy = p2.y-p1.y;
		return Math.sqrt(dx*dx + dy*dy);
	}
}

$("#organizePipe").mousedown(pipeClick).addClass('selected');
$("#organizeCone").mousedown(coneClick);
$("#organizeCircle").mousedown(circleClick);
$("#organizeSpiral").mousedown(spiralClick);
$("#organizeSwirl").mousedown(swirlClick);

function pipeClick(event) {
	$("#panel div a").removeClass('selected');
	$("#organizePipe").addClass('selected');
	vis.SetDisplayMode( vis.DISPLAY_PIPE ); 
}
function circleClick(event) { 
	$("#panel div a").removeClass('selected');
	$("#organizeCircle").addClass('selected');
	vis.SetDisplayMode( vis.DISPLAY_CIRCLE ); 
}
function spiralClick(event) { 
	$("#panel div a").removeClass('selected');
	$("#organizeSpiral").addClass('selected');
	vis.SetDisplayMode( vis.DISPLAY_SPIRAL ); 
}
function swirlClick(event) { 
	$("#panel div a").removeClass('selected');
	$("#organizeSwirl").addClass('selected');
	vis.SetDisplayMode( vis.DISPLAY_SWIRL ); 
}
function coneClick(event) { 
	$("#panel div a").removeClass('selected');
	$("#organizeCone").addClass('selected');
	vis.SetDisplayMode( vis.DISPLAY_CONE ); 
}

var vis = new Visualize();
vis.Initialize( "world" );
