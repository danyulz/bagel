
const textStyles = new Set(["normal", "lighter", "bold", "bolder", "h1", "h2", "h3", "h4"]);

let start_idx = 0;
let inputCount = 0;
let start_idxs = [0];
let focusIndex = 1;


const addListeners = (input, listenerType) => {

    console.log(listenerType);

    input.addEventListener("input", () => {

        if (input.value.includes("/")) {
            addAllCommands(input, listenerType);
        }
    })
}

const addAllCommands = (input, listenerType) => {

    input.addEventListener("input", function (event) {

        let command = commandListener(input);

        //command is not empty
        if (command != " ") {
            //command has ended, i.e. user has pressed space bar
            if (command.includes(" ")) {
                runListeners(input, command, listenerType);
                clearCommands_SpaceBar(input, command);
            }
        }
    });

    input.addEventListener("keydown", function (e) {

        let command = commandListener(input);

        if (command != "") {
            if (e.keyCode == 13) {
                e.preventDefault();
                runListeners(input, command, listenerType);
                clearCommands_Enter(input, command);
            }
        }
    })
}

const runListeners = (input, command, listenerType) => {

    console.log(listenerType);

    if (listenerType == "boardItem") {
        fontSizeListener(input, command);
        colorListener(input, command);
        textStyleListener(input, command);
        deleteListener(input, command);
        minimizeListener(input, command);
        testListener(input, command);
    } else if (listenerType == "boardInput") {
        createNewBoardItem(input, command);
    }
}

const commandListener = (input) => {

    //determine where command starts (idx)

    let idx = start_idxs[input.attributes.inputCount] > input.value.length - 1 ? start_idxs[input.attributes.inputCount] - 1 : input.value.length - 1;

    //if no commands have been made '/'
    if (start_idxs[input.attributes.inputCount] == 0) {
        idx = input.value.length - 1
    }

    for (let i = idx; i < input.value.length; ++i) {

        if (input.value[i] == '/') {
            start_idxs[input.attributes.inputCount] = i;
        }
    }

    //return command (str after '/')
    return input.value.substr(start_idxs[input.attributes.inputCount] + 1);
}

const commandParser = (command) => {

    let command_parsed = command;

    if (command.includes(" ")) {
        command_parsed = command.replace(" ", "");
    }

    return command_parsed;
}

const testListener = (input, command) => {
}

const createNewBoardItem = (input, command) => {
    if (commandParser(command) == "new") {
        var clickBtnValue = $(this).val();
        var ajaxurl = 'createBoardItem.php',
            data = {
                'action': clickBtnValue,
                'user_id': userId
            };
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            createBoardItem(++lastItemId, 'new board...')
        });
    }
}

const minimizeListener = (input, command) => {
    if (commandParser(command) == "bye" || commandParser(command) == "`") {
        minimizeHelper(input);
    }
}

const colorListener = (input, command) => {

    input.style.color = commandParser(command);
    shadowColorListener(input, commandParser(command));

}

const fontSizeListener = (input, command) => {
    input.style.fontSize = command.replace(" ", "") + "px";
}

const textStyleListener = (input, command) => {

    const command_parsed = command.replace(" ", "");

    let weight;
    let command_found = false;

    for (let item of textStyles) {

        //check item is in textStyles Set
        if (item == command_parsed) {
            weight = item;
            input.style.fontWeight = weight;
            command_found = true;
        }

        //special cases
        if (command_parsed == "b") {
            input.style.fontWeight = "bold";
            command_found = true;
        }
        else if (command_parsed == "h1") {
            input.style.fontSize = "2em";
            command_found = true;
        }
        else if (command_parsed == "h2") {
            input.style.fontSize = "1.5em";
            command_found = true;
        }
        else if (command_parsed == "h2") {
            input.style.fontSize = "1.17em";
            command_found = true;
        }
        else if (command_parsed == "h4") {
            input.style.fontSize = "1em";
            command_found = true;
        }
        else if (command_parsed == "h5") {
            input.style.fontSize = ".83em";
            command_found = true;
        }
        else if (command_parsed == "h6") {
            input.style.fontSize = ".67em";
            command_found = true;
        }

        if (command_found) {
            break;
        }
    }

    //ITALIZICIZE
    if (command_parsed == "tilt" || command_parsed == "i" || command_parsed == "slant") {
        input.style.fontStyle = "italic";
    }
    if (command_parsed == "r") {
        input.style.fontStyle = "initial";
        input.style.fontWeight = "initial";
    }
}

const shadowColorListener = (input, command) => {
    let inputWrapper = document.querySelector("#" + input.id + "-wrapper");

    inputWrapper.style.boxShadow = "0 0 10px 0.5px " + commandParser(command);
}

const deleteListener = (input, command) => {
    if (commandParser(command) == "q" || commandParser(command) == "delete" || commandParser(command) == "del" || commandParser(command) == "dlt" || commandParser(command) == "close" || commandParser(command) == "quit") {
        console.log("deleting");
        deleteHelper(document.querySelector("#" + input.id + "-wrapper"));
    }

    if (commandParser(command) == "new") {
        let inputWrapper = document.querySelector("#" + input.id + "-wrapper");

        let top = (+(inputWrapper.style.top.replace("px", "")) + 10) + "px";
        let left = (+(inputWrapper.style.left.replace("px", "")) + 10) + "px";

        console.log(top);
        console.log(left);

        let pos = [top, left];
        // console.log(pos);
        newInput(pos, inputWrapper.style.zIndex + 1);
    }

    console.log(commandParser(command))
    if (commandParser(command) == "clear") {
        input.value = "";
        start_idxs[input.attributes.inputCount] = 0;
    }
}

const deleteHelper = (inputWrapper) => {

    inputWrapper.className = "pop-out";
    setTimeout(function () {
        console.log("removing!");
        inputWrapper.remove();
    }, 150);
}

const addInputWrapperDynamicSizing = (inputWrapper, input) => {

    $("#" + inputWrapper.id).on('input', function () {

        let height = input.style.height > input.scrollHeight ? input.style.height : input.scrollHeight;
        $(input)
            .height(height)
            .width(input.scrollWidth)
            ;

        $("#" + inputWrapper.id).width(inputWrapper.scrollWidth);
    });
}

const minimizeHelper = (input) => {

    let inputWrapper = document.querySelector("#" + input.id + "-wrapper");

    // $("#" + inputWrapper.id).width(inputWrapper.scrollWidth);    

    $(input).slideUp(200);

}

const maximizeHelper = (input) => {

    let inputWrapper = document.querySelector("#" + input.id + "-wrapper");

    $(input).slideDown(200);
}

const clearCommands_SpaceBar = (input, command) => {
    input.value = input.value.replace("/" + command, "");
}

const clearCommands_Enter = (input, command) => {
    input.value = input.value.replace("/" + command, "");
}

function dragElement(elmnt) {

    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    if (elmnt.children[0]) {
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

$("#infoButton").click(() => {
    var newInputWrapper = document.createElement("div");
    newInputWrapper.id = "textarea-" + inputCount + "-wrapper";
    newInputWrapper.className = "fade-in";

    newInputWrapper.style.backgroundColor = "#f7f7f7";
    newInputWrapper.style.position = "absolute";
    newInputWrapper.style.borderRadius = "5px";
    newInputWrapper.style.boxShadow = "0 0 10px 0.5px #d9d9d9";

    // newInputWrapper.addEventListener("mouseleave", () => {
    //     console.log("hovering");
    //     minimizeHelper(newInput);
    // })

    var newInputHeader = document.createElement("div");
    newInputHeader.style.minHeight = "15px"
    newInputHeader.style.paddingInline = "3px";
    newInputHeader.style.fontSize = "0.8rem";
    newInputHeader.style.display = "flex";
    newInputHeader.style.alignItems = "center";
    newInputHeader.style.justifyContent = "space-between";

    newInputHeader.addEventListener("mouseenter", () => {
        maximizeHelper(newInput);
    })

    newInputHeader.id = newInputWrapper.id + "header";
    newInputHeader.className = "inputHeader";

    var line = document.createElement("hr");
    line.style.borderColor = "#e6e6e6";
    line.style.marginTop = "0";
    line.style.marginBottom = "0";
    line.style.borderStyle = "solid";
    line.style.borderWidth = "0.5px";

    var newInput = document.createElement("textarea");
    newInput.attributes.inputCount = inputCount;
    newInput.id = "textarea-" + inputCount;
    newInput.style.backgroundColor = "#f7f7f7";
    newInput.style.marginInline = "3px";
    newInput.style.paddingInline = "2px";
    newInput.style.fontFamily = "'DM Sans', sans-serif";

    newInput.innerHTML =
        "tips & tricks! \n\ncolors: /anycolor \n\nfont size: /# /h1, h2 ... \n\nfont style: /bold /b /tilt /i /r ... \n\n shortcuts: /clear /close /q /bye /delete /del"

    newInput.spellcheck = false;
    newInput.wrap = "on";
    newInput.style.width = newInput.scrollWidth;
    newInput.style.height = newInput.scrollHeight;

    console.log(newInput.scrollWidth);
    console.log(newInput.scrollHeight);

    var closeButton = document.createElement("div");
    closeButton.className = "closeButton";

    closeButton.addEventListener("click", () => {
        deleteHelper(newInputWrapper);
    });

    addInputWrapperDynamicSizing(newInputWrapper, newInput);
    newInputHeader.appendChild(closeButton);
    newInputWrapper.appendChild(newInputHeader);
    newInputWrapper.appendChild(line);
    newInputWrapper.appendChild(newInput);

    $(".container").append(newInputWrapper);

    dragElement(newInputWrapper);
    addListeners(newInput, "boardItem");

    inputCount++;
});

const newInput = (pos, zIndex) => {
    var newInputWrapper = document.createElement("div");
    newInputWrapper.id = "textarea-" + inputCount + "-wrapper";
    newInputWrapper.className = "fade-in";

    newInputWrapper.style.backgroundColor = "#f7f7f7";
    newInputWrapper.style.position = "absolute";
    newInputWrapper.style.borderRadius = "5px";
    newInputWrapper.style.zIndex = zIndex;
    newInputWrapper.style.boxShadow = "0 0 10px 0.5px #d9d9d9";

    if (pos != null) {
        newInputWrapper.style.top = pos[0];
        newInputWrapper.style.left = pos[1];
    }

    // newInputWrapper.addEventListener("mouseleave", () => {
    //     console.log("hovering");
    //     minimizeHelper(newInput);
    // })

    var newInputHeader = document.createElement("div");
    newInputHeader.style.minHeight = "15px"
    newInputHeader.style.paddingInline = "3px";
    newInputHeader.style.fontSize = "0.8rem";
    newInputHeader.style.display = "flex";
    newInputHeader.style.alignItems = "center";
    newInputHeader.style.justifyContent = "space-between";

    newInputHeader.addEventListener("mouseenter", () => {
        console.log("hovering");
        maximizeHelper(newInput);
    })

    newInputHeader.id = newInputWrapper.id + "header";
    newInputHeader.className = "inputHeader";

    var line = document.createElement("hr");
    line.style.borderColor = "#e6e6e6";
    line.style.marginTop = "0";
    line.style.marginBottom = "0";
    line.style.borderStyle = "solid";
    line.style.borderWidth = "0.5px";

    var newInput = document.createElement("textarea");
    newInput.attributes.inputCount = inputCount;
    newInput.id = "textarea-" + inputCount;
    newInput.style.backgroundColor = "#f7f7f7";
    newInput.style.marginInline = "3px";
    newInput.style.paddingInline = "2px";
    newInput.style.fontFamily = "'DM Sans', sans-serif";

    newInput.spellcheck = false;
    newInput.wrap = "on";

    var closeButton = document.createElement("div");
    closeButton.className = "closeButton";

    closeButton.addEventListener("click", () => {
        deleteHelper(newInputWrapper);
    });

    addInputWrapperDynamicSizing(newInputWrapper, newInput);
    newInputHeader.appendChild(closeButton);
    newInputWrapper.appendChild(newInputHeader);
    newInputWrapper.appendChild(line);
    newInputWrapper.appendChild(newInput);

    $(".container").append(newInputWrapper);

    dragElement(newInputWrapper);
    addListeners(newInput, "boardItem");

    inputCount++;
}

$("#addInputButton").click(() => {
    newInput();
}) 