<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<?php

if ($_SESSION["isLoggedIn"]) {

    if (isset($_GET["board_id"]) && !empty($_GET["board_id"])) {

        $user_id = $_SESSION["user_id"];
        $board_item_id = $_GET["board_id"];


        require('./util/db_connect.php');

        $statement_registered = $mysqli->prepare("SELECT * FROM board_items WHERE board_id = ?");
        $statement_registered->bind_param("i", $board_item_id);
        $execute_registered = $statement_registered->execute();

        if (!$execute_registered) {
            echo $mysqli->error;
        }

        $result = $statement_registered->get_result();

        $shouldLoadBoards = false;


        if ($result->num_rows > 0) {
            $shouldLoadBoards = true;
            $error = "found board";
        }

        $statement_registered->close();
    }
}

?>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar-styles.css">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="input/input.js"></script>

<body>
    <?php $type = "home";
    require('./navbar/navbar.php') ?>
    <button class="save-button box-shadow fade-in">Save</button>
    <div class="container">
        <?php if ($_SESSION["isLoggedIn"] && isset($_GET["board_id"]) && !empty($_GET["board_id"]) && $shouldLoadBoards) : ?>
            <script>
                let css_styles_parsed;
                let css_textarea_style_parsed;
            </script>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <script>
                    css_styles_parsed = '<?php echo $row["css_style"]; ?>'.replace(/["']/g, "'");
                    css_textarea_style_parsed = '<?php echo $row["css_textarea_styles"]; ?>'.replace(/["']/g, "'");

                    newInput(null, null, "<?php echo $row["css_id"]; ?>", css_styles_parsed, "<?php echo $row["css_value"]; ?>", css_textarea_style_parsed);
                </script>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <button class="box-shadow fade-in" id="addInputButton" type="button">+</button>
    <button class="box-shadow fade-in" id="infoButton" type="button">?</button>
    <script>
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

        $("#addInputButton").click(() => {
            newInput();
        })
    </script>
    <script src="addInputButton/addInputButton.js"></script>
    <script src="userBoards/loadBoardItems.js"></script>
    <script>
        let button = document.querySelector(".save-button");

        let board_id = <?php echo $board_item_id; ?>;

        const saveBoardState = (board_id, css_id, css_class, css_style, css_attributes, css_textarea_style, css_value, start_idx) => {

            // console.log(board_id)
            console.log(css_id)
            // console.log(css_style)
            // console.log(css_attributes)
            // console.log(css_textarea_style)
            // console.log(css_value)
            // console.log(start_idx)

            var ajaxurl = 'saveBoardItem.php',
                data = {
                    'board_id': board_id,
                    'css_id': css_id,
                    'css_class': css_class,
                    'css_style': css_style,
                    'css_attributes': css_attributes,
                    'css_textarea_style': css_textarea_style,
                    'css_value': css_value,
                    'start_idx': start_idx,

                };
            $.post(ajaxurl, data, function(response) {
                console.log(response);
            });
        }


        button.addEventListener("click", () => {
            const boards = document.querySelector(".container").children;

            console.log(boards.length)

            const boardsArr = [];

            for (let i = 0; i < boards.length; i++) {
                if (boards[i].tagName == "DIV") {
                    boardsArr.push(boards[i])
                }
            }
            //start i @ 1 to ignore the script element
            for (let i = 0; i < boardsArr.length; i++) {
                let css_id = boardsArr[i].id.replace("textarea-", "").replace("-wrapper", "");
                let css_class = boardsArr[i].className;
                let css_style = boardsArr[i].style.cssText;
                let css_attributes = ""; // no attributes for now
                let textAreaTemp = document.getElementById("textarea-"+css_id);
                let css_value = textAreaTemp.value;
                console.log(textAreaTemp)
                let start_idx = 0 //start at beginning for now, should just recalculate start idx each time.
                let css_textarea_style = boardsArr[i].children[2].style.cssText;

                saveBoardState(<?php echo $board_item_id; ?>, css_id, css_class, css_style, css_attributes, css_textarea_style, css_value, start_idx);
            }
        });
    </script>
</body>

</html>