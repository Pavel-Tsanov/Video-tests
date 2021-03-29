var questionNumber = 1;
var answersNumber = 1;

function addQuestion() {
    answersNumber = 1;
    alignStars(questionNumber);
    var newQuestion = document.createElement("div");
    newQuestion.setAttribute("id", "Question" + questionNumber);
    var questionId = newQuestion.getAttribute("id");

    let label1 = document.createElement("label");
    label1.innerHTML = "Въпрос " + questionNumber + ". ";
    label1.setAttribute("for", "questionText" + questionNumber);
    newQuestion.appendChild(label1);

    let textArea = document.createElement("textarea");
    setAttributes(textArea, {
        "id": "questionText" + questionNumber,
        "name": "questionText[" + questionNumber + '][]',
        "rows": "2",
        "cols": "30"
    });
    newQuestion.appendChild(textArea);

    let toClose = document.createElement("span");
    setAttributes(toClose, {"class": "closing"});
    toClose.innerHTML = 'X';

    toClose.addEventListener("click",() => {
        questionNumber--;
        newQuestion.remove();

        let remainingQuestions = document.querySelectorAll("#formID div");

        for(let i = 1;i < questionNumber;i++) {
            let question = remainingQuestions[i - 1];

            question.id = "Question" + i;
            let label = question.querySelector('label');
            label.innerHTML = `Въпрос ${i}. `;
        }
    })


    newQuestion.appendChild(toClose);
    newQuestion.appendChild(document.createElement("br"));

    let checkBox = document.createElement("input");
    setAttributes(checkBox, {"id": "forVideos" + questionNumber, "type": "checkbox", "name": "video"});

    checkBox.addEventListener("click",() =>{
        if(checkBox.checked == true) {
            inputTag.style.display = "block";
            videoTag.style.display = "block";
        }
        else{
            inputTag.style.display = "none";
            videoTag.style.display = "none";
        }
    })

    let checkLabel = document.createElement("label");
    checkLabel.innerHTML = "Отбележи за видео";

    setAttributes(checkLabel, {"for": "forVideos" + questionNumber});
    newQuestion.appendChild(document.createElement("br"));
    newQuestion.appendChild(checkLabel);
    newQuestion.appendChild(checkBox);


    let inputTag = document.createElement("input");
    setAttributes(inputTag, {"id": "inputTag" + questionNumber, "type": "file", "name": "videoInput" + questionNumber, "accept": "video/*","style":"display:none"});
    newQuestion.appendChild(inputTag);
    let videoTag = document.createElement("video");
    setAttributes(videoTag, {"id": "videoTag" + questionNumber, "controls": "true","style":"display:none"});
    newQuestion.appendChild(document.createElement("br"));
    newQuestion.appendChild(videoTag);


    let addAnswerBtn = document.createElement("button");
    setAttributes(addAnswerBtn, {"id": "answerBtn" + questionNumber, "type": "button"});
    addAnswerBtn.innerHTML = "Добави отговор";
    newQuestion.appendChild(document.createElement("br"));
    newQuestion.appendChild(addAnswerBtn);

    addAnswerBtn.addEventListener("click", () => {
        newQuestion.appendChild(document.createElement("br"));
        let newAnswer = document.createElement("input");
        setAttributes(newAnswer, {
            "class": "answers" + questionId,
            "type": "checkbox",
            "name": "answer[" + questionId + '][' + answersNumber + ']',
            "value": answersNumber
        });
        answersNumber++;

        let answerText = document.createElement("input");
        setAttributes(answerText, {
            "class": "answersText" + questionId,
            "type": "text",
            "name": "answersText[" + questionId + '][' + (answersNumber - 1) + ']'
        });
        newQuestion.appendChild(newAnswer);
        newQuestion.appendChild(answerText);
    });

    document.getElementById("formID").appendChild(newQuestion);
    questionNumber++;
    var answersNumber = 1;

    (function Preview_Video() {
        var URL = window.URL || window.webkitURL;

        var Play_Video = function (event) {
            var file = this.files[questionNumber - 1];
            var type = file.type;
            var fileURL = URL.createObjectURL(file);
            videoTag.src = fileURL;
        }

        var inputNode = document.getElementById("inputTag" + questionNumber);
        inputNode.addEventListener('change', Play_Video, false)
    })()

}


function setAttributes(el, attrs) {
    for (let key in attrs) {
        el.setAttribute(key, attrs[key]);
    }
}

function validateTest(){
    alignStars(questionNumber);
    let questionsNumber = document.querySelectorAll("#formID div").length,anyError = false;

    if(document.querySelector("body div") !== 0)
        document.body.removeChild(document.body.lastChild);

    let errDiv = document.createElement("div");
    errDiv.setAttribute("class", "pop-up")

    if(!document.getElementById("testName").value)
        addErrMsg(errDiv,"Няма заглавие на теста!");


    if(questionsNumber == 0) {
        addErrMsg(errDiv,"Няма тест без въпроси!");
    }

    for(let i = 1;i <= questionsNumber; i++){
        if(document.getElementById("questionText" + i).value === "") {
            addErrMsg(errDiv,`Липсва условие на въпрос ${i}!`);
            anyError = true;
        }

        if(document.getElementsByClassName("answersTextQuestion" + i).length === 0)
            addErrMsg(errDiv,`Въпрос ${i} няма нито един отговор!`);
        else {

            const uncheckedAnswers = (answer) => answer.checked === false;

            if (Array.from(document.getElementsByClassName("answersQuestion" + i)).every(uncheckedAnswers)) {
                addErrMsg(errDiv,`Трябва да има поне един верен отговор на въпрос ${i}!`);
                anyError = true;
            }

            const noAnswersText = (text) => text.value === "";

            if (Array.from(document.getElementsByClassName("answersTextQuestion" + i)).some(noAnswersText)) {
                addErrMsg(errDiv,"Всеки отговор трябва да има текст!");
                anyError = true;
            }
        }

    }
    //document.getElementById("error-pop-up").appendChild(errDiv);
    document.body.appendChild(errDiv);
}

function addErrMsg(errDiv,errMsg){
    event.preventDefault();
    errDiv.innerHTML += errMsg;
    err = document.createElement("br");
    errDiv.appendChild(err);
}

function alignStars(questionNumber){
    let remainingQuestions = document.querySelectorAll("#formID div");

    for(let i = 1;i < questionNumber;i++){
        let question = remainingQuestions[i - 1];

        question.id = "Question" + i;
        questionId = question.id;

        let label = question.querySelector('label');
        label.innerHTML = `Въпрос ${i}. `;
        setAttributes(label,{"for":"questionText" + i});

        let textArea = question.querySelector("textarea");
        setAttributes(textArea, {
            "id": `questionText${i}`,
            "name": "questionText[" + i + '][]'});

        let videoLabel = question.querySelectorAll("label")[1];
        videoLabel.setAttribute("for","forVideos" + i);

        inputsQuery = question.querySelectorAll("input");
        inputsQuery[0].setAttribute("id","forVideos"+i);

        setAttributes(inputsQuery[1],{"id":"inputTag" + i,"name":"videoInput"+i});
        setAttributes(question.querySelector("video"),{"id":"videoTag"+i});

        let tmp = 1;
        for(let answerInd = 2;answerInd <= (inputsQuery.length - 2);answerInd+=2){
            setAttributes(inputsQuery[answerInd],{"class":"answersQuestion"+i,"name":'answer[Question' + i + '][' + tmp + ']'});
            setAttributes(inputsQuery[answerInd + 1],{"class":"answersTextQuestion"+i,"name":'answersText[Question' + i + '][' + tmp + ']'});
            tmp++;
        }

        question.querySelector("button").setAttribute("id","answerBtn"+i);
    }
}
