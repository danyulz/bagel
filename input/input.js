
const textStyles = new Set(["normal", "lighter", "bold", "bolder", "100", "200", "300", "400", "500", "600", "700", "800", "900"]);

let start_idx = 0;
let inputCount = 0;
let focusIndex = 1;

// $('#textarea-1-wrapper').on('input', function() {

//     let height = this.style.height > this.scrollHeight ? this.style.height : this.scrollHeight;
//     $(this)
//       .height(50)
//       .height(height)
//   });

// const addDynamicResize = (input) => {
    
    // input.on('input', () => {
    //     $(this)
    //         .width(50)
    //         .height(50)
    //         .width(this.scrollWidth)
    //         .height(this.scrollHeight);
    // });
// }


const addListeners = (input) => {

    input.addEventListener("input", () => {

        if (input.value.includes("/")) {
            addAllCommands(input);
        }
    })
}

const addAllCommands = (input) => {
    input.addEventListener("input", textStyleListener(input));
    input.addEventListener("input", colorListener(input));
}

const commandListener = (input) => {

    //determine where command starts (idx)

    let idx = start_idx < input.value.length - 1 ? start_idx : input.value.length - 1;

    //if no commands have been made '/'
    if (start_idx == 0) {
        idx = input.value.length - 1
    }

    for (let i = idx; i < input.value.length; ++i) {

        if (input.value[i] == '/') {
            start_idx = i;
        }
    }

    //return command (str after '/')
    return input.value.substr(start_idx + 1);
}

const colorListener = (input) => {

    let command = commandListener(input);

    //command is not empty
    if (command != "") {

        //command has ended, i.e. user has pressed space bar
        if (command.includes(" ") && command != " ") {

            //change color of input
            input.style.color = command.replace(" ", "");
            input.value = input.value.replace("/" + command, "");
        }
    }

}

const textStyleListener = (input) => {

    let command = commandListener(input);

    //command is not empty
    if (command != "") {

        //command has ended, i.e. user has pressed space bar
        if (command.includes(" ")) {

            const command_parsed = command.replace(" ", "");

            let weight;

            for (let item of textStyles) {

                if (item == command_parsed) {
                    weight = item;
                    input.style.fontWeight = weight;
                    input.value = input.value.replace(" /" + weight, "");
                }
            }
        }
    }

}

function dragElement(elmnt) {
    console.log(elmnt.children);
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    if (elmnt.children[0]) {
        console.log("has header");
        // if present, the header is where you move the DIV from:
        elmnt.children[0].onmousedown = dragMouseDown;
    } else {
        // otherwise, move the DIV from anywhere inside the DIV:
        elmnt.onmousedown = dragMouseDown;
    }

    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        // calculate the new cursor position:
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.zIndex = ++focusIndex;
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }

    function closeDragElement() {
        // stop moving when mouse button is released:
        document.onmouseup = null;
        document.onmousemove = null;
    }
}

$("#addInputButton").click(() => {
    var newInputWrapper = document.createElement("div");
    newInputWrapper.id = "textarea-" + ++inputCount + "-wrapper";
    
    newInputWrapper.style.backgroundColor = "#f7f7f7";
    newInputWrapper.style.position = "absolute";
    newInputWrapper.style.borderRadius = "5px";
    newInputWrapper.style.boxShadow = "0 0 10px 1px #d9d9d9";

    var newInputHeader = document.createElement("div");
    newInputHeader.innerHTML = "click me";
    newInputHeader.style.paddingInline = "3px";
    newInputHeader.style.fontSize = "0.8rem";

    newInputHeader.id = newInputWrapper.id + "header";

    var line = document.createElement("hr");
    line.style.borderColor = "#e6e6e6";
    line.style.marginTop = "0";
    line.style.marginBottom = "0";
    line.style.borderStyle = "solid";
    line.style.borderWidth = "0.5px";

    var newInput = document.createElement("textarea");
    newInput.id = "textarea-" + inputCount;
    newInput.style.backgroundColor = "#f7f7f7";
    newInput.style.marginInline = "2px";
    newInput.style.paddingInline = "2px";
    
    newInput.spellcheck = false;
    newInput.wrap = "on";

    newInputWrapper.appendChild(newInputHeader);
    newInputWrapper.appendChild(line);
    newInputWrapper.appendChild(newInput);

    dragElement(newInputWrapper);
    addListeners(newInput);
    $(".container").append(newInputWrapper);
}) 