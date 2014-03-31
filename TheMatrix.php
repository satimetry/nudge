<!DOCTYPE HTML>
<html lang="en">

   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      
      <link rel="stylesheet" href="css/themes/nudgetheme.min.css" />
      <link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css" />
      <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile.structure-1.4.0.min.css" />

      <script src="js/kinetic-v5.0.0.min.js"></script>
      <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
      <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>            

      <link rel="stylesheet" href="css/nudge.css" />      
      <script src="js/nudge.js"  ></script>  

      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>The Matrix</title>
   </head>

   <body>

   <!-- Begin: Matrix Page -->
   <div data-theme="a" id="pageMatrix" data-role="page" data-fullscreen="false"><section>

      <script> writeHeader("backhome", "matrixcheck"); </script>

         <div data-role="content">
            <div class="content-primary" id="User">
               <style="font-size:11px;" for="behavior" data-inline="true">Touch screen to place marker</style>
               <input data-clear-btn="true" data-mini="true" type="text" id="behavior" name="behavior" class="behavior" placeholder="Enter behavior here, click check to save" value="" data-inline="true">

               <div id="container"></div>
               <canvas id="myCanvas" ></canvas>
            </div>
         </div>
           
      <script> writeFooter(); </script> 
         
   </section></div>
      <!-- End: Matrix Page -->

      <script>
         DEBUG = true;

         setTimeout(CheckResolution, 300);
         function CheckResolution() {
            //do soemthing here
         }

         var viewport = {
            width : $(window).width(),
            height : $(window).height()
         };


         // Listeners Not working!
         //window.addEventListener("resize", checkOrientation, false);

         // Listen for orientation changes
         window.addEventListener("orientationchange", function() {

            paintStage();
            circle.remove();
            circleLayer.remove();
            for (var i = 0; i < axislabels.length; i++) {
               axislabels[i].remove();
            }
            rect.setWidth(stage.getWidth());
            rect.setHeight(stage.getHeight());
            axisLayer.add(rect); 
            drawAxes();
            drawLabels();

            // This will remove the address bar
            window.scrollTo(0, 1);
         }, false);

         // (optional) Android doesn't always fire orientationChange on 180 degree turns
         //setInterval(checkOrientation, 2000);

         var messageLayer = new Kinetic.Layer();
         function writeMessage(messageLayer, message) {
            
            var msgcontext = messageLayer.getContext();
            messageLayer.clear();
            msgcontext.font = '6pt Calibri';
            msgcontext.fillStyle = 'black';
            msgcontext.fillText(message, 20, 50);
         }

         var debugLayer = new Kinetic.Layer();
         function debugMessage(debugLayer, message) {
            var msgcontext = debugLayer.getContext();
            debugLayer.clear();
            msgcontext.font = '6pt Calibri';
            msgcontext.fillStyle = 'black';
            msgcontext.fillText(message, 15, 25);
         }

         function writeCanvasMessage(canvas, message) {
            var context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.font = '6pt Calibri';
            context.fillStyle = 'black';
            context.fillText(message, 20, 30);
         }

         var canvas = document.getElementById('myCanvas');
         function getMousePos(canvas, evt) {
            var rectangle = canvas.getBoundingClientRect();
            return {
               x : evt.clientX - rectangle.left,
               y : evt.clientY - rectangle.top
            };
         }

         var context = canvas.getContext('2d');
         canvas.addEventListener('touchmove touchend touchend touchstart tap dbltap dragstart dragmove dragend', function(evt) {
            var touchPos = getTouchPosition(canvas, evt);
            var message = 'Touch position: ' + touchPos.x + ',' + touchPos.y;
            if (DEBUG) {
               writeCanvasMessage(canvas, message);
            }
         }, false);

         if (window.innerHeight > window.innerWidth) {
            // alert("Please rotate your phone to landscape");
         }

         // Build the stage
         var stage = new Kinetic.Stage({
            container : 'container',
         });
         function drawStage(x, y) {
            stage.setWidth(x);
            stage.setHeight(y);
            //stage.remove();
            //stage.setContainer('container');
         }

         function paintStage() {
            h = window.innerHeight;
            w = window.innerWidth;
            if (w > 720)  { w = 720; }
            if ( h > w ) {
               drawStage(w - 40, h - 180);
            } else {
               drawStage(w - 40, h - 0);         
            }
         }
         
         paintStage();
         
         // Build the axes layer
         var axisLayer = new Kinetic.Layer();
         var xaxis = new Kinetic.Line();
         var yaxis = new Kinetic.Line();
         function drawAxes() {

            stage.remove(axisLayer);
            axisLayer.remove(xaxis);
            axisLayer.remove(yaxis);
            
            xaxis.setPoints([60, stage.getHeight() / 2, stage.getWidth() - 60, stage.getHeight() / 2]);
            xaxis.setStroke('black');
            xaxis.setStrokeWidth(3);
            xaxis.setLineCap('round');
            xaxis.setLineJoin('round');
            xaxis.setDraggable(false);
            yaxis.setPoints([stage.getWidth() / 2, 40, stage.getWidth() / 2, stage.getHeight() - 30]);
            yaxis.setStroke('black');
            yaxis.setStrokeWidth(3);
            yaxis.setLineCap('round');
            yaxis.setLineJoin('round');
            yaxis.setDraggable(false);

            axisLayer.add(xaxis);
            axisLayer.add(yaxis);
            stage.add(axisLayer);            
         }

         var axislabels = new Array();         
         var labelsLayer = new Kinetic.Layer();
         function drawLabels() {
                        
            labelsLayer.clear();
            labelsLayer.remove();
            stage.remove(labelsLayer);

            axislabels[0] =  new Kinetic.Text({ x: 0, y: 0, });
            axislabels[1] =  new Kinetic.Text({ x: 0, y: 0, });
            axislabels[2] =  new Kinetic.Text({ x: 0, y: 0, });
            axislabels[3] =  new Kinetic.Text({ x: 0, y: 0, });

            axislabels[0].setText('5-Senses Experiencing');
            axislabels[0].setX((stage.getWidth() / 2) - 80);
            axislabels[0].setY(0);

            axislabels[1].setText('Toward');
            axislabels[1].setX(stage.getWidth() - 70);
            axislabels[1].setY((stage.getHeight() / 2) - 25);

            axislabels[2].setText('Mental Experiencing');
            axislabels[2].setX((stage.getWidth() / 2) - 70);
            axislabels[2].setY(stage.getHeight() - 40);

            axislabels[3].setText('Away');
            axislabels[3].setX(0);
            axislabels[3].setY((stage.getHeight() / 2) - 25);

            for (var i = 0; i < axislabels.length; i++) {
               axislabels[i].setPadding(15);
               axislabels[i].setFill('black');
               axislabels[i].setFontStyle('bold');
               axislabels[i].setDraggable(false);
               axislabels[i].setFontSize(13);
               axislabels[i].setFontFamily('Calibri');
               labelsLayer.add(axislabels[i]);
            }
            stage.add(labelsLayer);
         }

         var behavior = "";
         var behaviorLayer = new Kinetic.Layer();
         behaviorlabel =  new Kinetic.Text({ x: 0, y: 0, });
         function drawBehavior() {
 
            var behaviorcontext = behaviorLayer.getContext();           
            behavior = document.getElementById("behavior").value;                       
            behaviorLayer.clear();
            behaviorLayer.remove();
            stage.remove(behaviorLayer);
            behaviorlabel.remove();
            
            behaviorx = realx;
            behaviory = realy;
            behaviorlabel.setText(behavior);
            if ( (realx + behaviorlabel.getWidth() ) > stage.getWidth() ) {
               behaviorx = realx - behaviorlabel.getWidth();
            }
            if ( realy > ( stage.getHeight() - behaviorlabel.getHeight() - 20 ) ) {
               behaviory = realy - behaviorlabel.getHeight();
            }
            behaviorlabel.setX(behaviorx);
            behaviorlabel.setY(behaviory);
            
//            behaviorlabel.setX((stage.getWidth() / 2) - 100);
//            behaviorlabel.setY(0);

            behaviorlabel.setPadding(15);
            behaviorlabel.setFill('black');
            behaviorlabel.setFontStyle('bold');
            behaviorlabel.setDraggable(false);
            behaviorlabel.setFontSize(16);
            behaviorlabel.setFontFamily('Calibri');
            behaviorLayer.add(behaviorlabel);
  
            stage.add(behaviorLayer);
         }
         
         var circleLayer = new Kinetic.Layer();

         var rect = new Kinetic.Rect({
            x : 0 + 10,
            y : 0 + 10,
            width : stage.getWidth(),
            height : stage.getHeight(),
            strokeWidth : 1,
            stroke : 'gray',
            fill : 'lightgray',
            opacity : 0.5
         });
         axisLayer.add(rect);

/*
          circle.on('mouseover', function() {
          //        writeMessage(messageLayer, '(' + circle.getX() + ', ' + circle.getY() + ')');
          writeMessage(messageLayer, '(' + w + ', ' + h + ')');
          });
          circle.on('mouseout', function() {
          writeMessage(messageLayer, '');
          });
          circle.setListening(true);
*/

         var newX = 0;
         var newY = 0;
         rect.on('mousemove', function() {
            var mousePos = stage.getPointerPosition();
            newX = parseInt(mousePos.x);
            newY = parseInt(mousePos.y);
         });

         var realx = 0;
         var realy = 0;
         function printCircleLocation(x, y) {
            realx = x;
            realy = y;
            stdx = ((x/stage.getWidth())*100).toFixed(3);
            stdy = ((y/stage.getHeight())*100).toFixed(3);
//            debugMessage(debugLayer, '(' + stdx + ', ' + stdy + ')');            
         }
         
         var stdx = -100;
         var stdy = -100;
         function dragfunc(pos) {
            var mousePos = stage.getPointerPosition();
            x = parseInt(mousePos.x);
            y = parseInt(mousePos.y);
            printCircleLocation(x, y);
            drawBehavior();
            return {
               x : parseInt(mousePos.x),
               y : parseInt(mousePos.y)
            }
         }

         // Build the circle layer
         var circle = new Kinetic.Circle();
         function drawCircle(x, y) {
            var circlecontext = circleLayer.getContext();
            circleLayer.remove();
            stage.remove(circleLayer);
            
            //circlecontext.clear();
            // circle.setClearBeforeDraw(true);
            circle.setRadius(10);
            circle.setFill('red');
            circle.setStroke('black');
            circle.setStrokeWidth(3);
            circle.setDraggable(true);
            circle.setDragBoundFunc(dragfunc);
            circle.setX(x);
            circle.setY(y);
            
            circleLayer.add(circle);
            stage.add(circleLayer);
         }


         rect.on('click touchmove touchend touchend touchstart tap dbltap dragstart dragmove dragend', function() {
            var touchPos = stage.getTouchPosition();
            newX = touchPos.x;
            newY = touchPos.y;
            drawCircle(newX, newY);
            printCircleLocation(newX, newY);
            drawBehavior();
         });
         
         rect.on('mousedown touchstart', function() {
            var mousePos = stage.getPointerPosition();
            newX = parseInt(mousePos.x);
            newY = parseInt(mousePos.y);
            drawCircle(newX, newY);
            printCircleLocation(newX, newY);
            drawBehavior();
          });
          
         rect.on('mousedown touchend', function() {
            var mousePos = stage.getPointerPosition();
            newX = parseInt(mousePos.x);
            newY = parseInt(mousePos.y);
            drawCircle(newX, newY);
            printCircleLocation(newX, newY);
            drawBehavior();
          });
          
         rect.on('dblclick dbltap', function() {
            var mousePos = stage.getPointerPosition();
            newX = parseInt(mousePos.x);
            newY = parseInt(mousePos.y);
            drawCircle(newX, newY);
            printCircleLocation(newX, newY);
            drawBehavior();
         });
          
         rect.setListening(true);

         stage.add(messageLayer);
         stage.add(debugLayer);

         drawAxes();
         drawLabels();
                             
         // This will remove the address bar
         window.scrollTo(0, 1);

$('#getcircle').click(function() {
   behavior = document.getElementById("behavior").value;
   alert(behavior + " @ (" + stdx + ", " + stdy + ")");
}); 

$('#matrixcheck').click(function() {
   behavior = document.getElementById("behavior").value;
   drawBehavior();
   alert("Saving " + behavior + " @ ( " + stdx + "%, " + stdy + "% )");
}); 

      </script>

   </body>
</html>
