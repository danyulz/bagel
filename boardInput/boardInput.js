const createNewBoardItem = (input, command) => {
    if (commandParser(command).includes("new")) {

        let boardName = "untitled";

        if (commandParser(command).includes("new->")) {
            boardName = commandParser(command).replace("new->", "");
        }

        var ajaxurl = 'createBoardItem.php',
            data = {
                'action': boardName,
                'user_id': userId
            };
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            createBoardItem(++lastItemId, boardName)
        });
    }
}

const deleteBoardItem = (input, command) => {
    let commandAlias = null;

    if (commandParser(command).includes("delete->")) {
        commandAlias = "delete->";
    }

    else if (commandParser(command).includes("del->")) {
        commandAlias = "del->";
    }

    if (commandAlias != null) {

        let boardName = commandParser(command).replace(commandAlias, "");
        let boardItems = document.querySelectorAll(".board-item");

        //find correct boardItem using boardName
        for (let i = 1; i < boardItems.length; i++) {
            if (boardItems[i].children[0].innerHTML == boardName) {
                addDeleteBoard(boardItems[i]);
            }
        }

    }
}

// const renameBoardListener = (input, command) => {

//     let commandAlias = null;

//     if (commandParser(command).includes("->")) {
//         commandAlias = "rename->";
//     }

//     for (let i = 0; i < commandParser(command).length; i++) {
        
//     }

//     if (commandAlias != null) {

//         let boardName = commandParser(command).replace(commandAlias, "");
//         let boardItems = document.querySelectorAll(".board-item");

//         //find correct boardItem using boardName
//         for (let i = 1; i < boardItems.length; i++) {
//             if (boardItems[i].children[0].innerHTML == boardName) {
//                 addDeleteBoard(boardItems[i]);
//             }
//         }

//         let id = board.id.replace("item-", "");
//         board.className += " pop-out";
//         setTimeout(function () {
//             board.remove();
//         }, 150);

//         var ajaxurl = 'deleteBoardItem.php',
//             data = {
//                 'board_items_id': id
//             };
//         $.post(ajaxurl, data, function (response) {
//             console.log(response);
//         });

//     }
// }

