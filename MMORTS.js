// Custom Classes \\
class Player{
  constructor(){
    this.mousePos={x:undefined,y:undefined};
  }

  //Every frame when build mode is selected
  BuildMode_HighlightCell(){
    var gridCellSize = cellSize;  // Set cell size

    var mouseGridPos=CanvasToGridPos(playerObj.mousePos.x, playerObj.mousePos.y, gridCellSize);
    // Draw Background
    ctx.fillStyle = "lightgreen";
    ctx.fillRect(mouseGridPos[0],mouseGridPos[1], gridCellSize,gridCellSize);
  }
}

class GameObject{
  constructor(name,position=RandomPositionOnCanvas(),size){
    this.name     = name;
    this.position = { x:position.x, y:position.y};
    this.size     = [size[0],size[1]];
    this.text     = "😈";
  }
  
  DrawGameObject(){ 
    ctx.fillStyle = "white";
    ctx.fillRect(this.position.x, this.position.y, this.size[0],this.size[1]);
  }

  isMouseOver(mouseX, mouseY) {
    if(this.isIndoors){return false;}
    var mouseHitBox=10;
    return (
      mouseX >= (this.position.x - (mouseHitBox)) &&
      mouseX <= this.position.x + this.size[0] + mouseHitBox &&
      mouseY >= (this.position.y - mouseHitBox) &&
      mouseY <= this.position.y + this.size[1] + mouseHitBox
    );
  }

  SpawnGameObject() {
    // Initialization code here
    this.DrawGameObject();

    //Push character to active spawned character list
    charCount+=1;
    this.name=this.name+charCount;
    activeGameObjectsArray.push(this);
    console.log("Character "+this.name+" initialized.");
  }
}


// FUNCTIONS \\
function DrawFloor(){
  ctx.fillStyle = "teal";
  ctx.fillRect(0, 0, canvas.width, canvas.height);
}

function CanvasToGridPos(pointX, pointY) {
  // Calculate the number of cells in both dimensions
  const numCellsX = Math.floor(canvas.width / cellSize);
  const numCellsY = Math.floor(canvas.height / cellSize);

  // Calculate the grid position by rounding to the nearest cell
  const gridPosX = Math.round(pointX / cellSize);
  const gridPosY = Math.round(pointY / cellSize);

  // Ensure the grid position is within the valid range
  const clampedGridPosX = Math.max(0, Math.min(numCellsX - 1, gridPosX));
  const clampedGridPosY = Math.max(0, Math.min(numCellsY - 1, gridPosY));

  // Calculate the final coordinates of the closest cell
  const closestCellX = clampedGridPosX * cellSize;
  const closestCellY = clampedGridPosY * cellSize;

  /* Return the result as an object
  return {
      x: closestCellX,
      y: closestCellY,
      gridPosX: clampedGridPosX,
      gridPosY: clampedGridPosY,
  };
  */
 return [closestCellX,closestCellY];
}

function UpdateMousePos(event){
  // Get Mouse pos
  const rect = canvas.getBoundingClientRect();
  playerObj.mousePos.x = event.clientX - rect.left;
  playerObj.mousePos.y = event.clientY - rect.top;
  //return mousePos={x:mouseX, y:mouseY};
}

// OnClick Event Listener Function
function OnClick(event){
  console.log("Click! "+CanvasToGridPos(playerObj.mousePos.x,playerObj.mousePos.y,cellSize));
  //SpawnStructure();
  var mouseGridPos=CanvasToGridPos(playerObj.mousePos.x, playerObj.mousePos.y, cellSize);
  var newGameObject = new GameObject("GameObject",{x:mouseGridPos.x,y:mouseGridPos.y},[25,25]);
  newGameObject.SpawnGameObject();
}

//Generate random spawn point on canvas
function RandomPositionOnCanvas(){
  return {x:(Math.random()*canvas.width), y:(Math.random()*canvas.height)};
}



// MAIN GAME SEQUENCE \\

// Initialize Variables \\
var canvas = document.getElementById("myCanvas");
var ctx = canvas.getContext("2d");
//Set Main loop variables
var lastTime = performance.now();
var deltaTime = 0;
var interval = 16; // 60 fps
const playerObj = new Player();
var cellSize=25;
var activeGameObjectsArray=[];
var charCount=0;

//Run at Startup
function Start(){
  // Prepare Canvas
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
  // Draw Floor
  canvas.style.backgroundColor = "teal";

  //Add event listener
  canvas.addEventListener("mousemove", UpdateMousePos);
  canvas.addEventListener("click", OnClick);


  //Spawn beginning chars
  //var block=new GameObject("block",{x:20,y:20},[25,25]);
  //block.SpawnGameObject();
}

function Update() {
  var now = performance.now();
  // calculate the difference in time from last loop
  deltaTime += now - lastTime;
  lastTime = now;

  //While delta time is greater than or equal to the set interval of 16 for 60 FPS
  while (deltaTime >= interval) {
    //subtract interval from deltatime
    deltaTime -= interval;
  }

  //===~* MAIN FUNCTION *~===\\
  DrawFloor();
  playerObj.BuildMode_HighlightCell();
  //For each active character in game...
  activeGameObjectsArray.forEach(gameObject => {
    gameObject.DrawGameObject();
  });




  // render the game graphics, recursive loop....
  requestAnimationFrame(Update);
}

Start();
requestAnimationFrame(Update);

