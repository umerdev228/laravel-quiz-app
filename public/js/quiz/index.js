function numberOfQuestions() {
    let questions = document.querySelector('#num_of_questions').value
    let answers = document.querySelector('#num_of_answers').value
    if (questions > 0 && answers > 0)
    document.getElementById("question-answers").innerHTML = '';
    for (let i = 0; i < questions; i++) {
            addQuestions(i + 1, answers)
            getNumberOfAnswers(i + 1, answers)
        }
}
function addQuestions(index, answers) {
    let x = `<div class="mb-3">
                <label for="question-`+index+`" class="col-md-4 col-form-label" style="font-weight: bold;">Question `+index+`</label>
                <div class="col-md-12" id="question-container-`+index+`">
                    <input id="question-`+index+`" type="text" class="form-control" name="question-`+index+`" required autocomplete="question-`+index+`">
                </div>
            </div>
            <hr>`

    document.getElementById("question-answers").insertAdjacentHTML('beforeend', x);

}
function getNumberOfAnswers(i, answers) {
    for (let a = 0; a < answers; a++) {
        let x = `<div class="col-md-8 mb-3 row">
                    <label for="answer-`+a+`" class="col-md-4 col-form-label">Option `+ (a + 1) +`</label>
                    <div class="form-check col-md-3">
                        <input class="form-check-input" type="radio" id="answer-correct-`+a+`-`+i+`" value="`+(a+1)+`" name="answer-correct-`+i+`" required>
                        <label class="form-check-label" for="answer-correct-`+a+`-`+i+`">
                            Is Correct
                        </label>
                    </div>
                    <div class="col-md-8">
                        <input id="answer-`+a+`" type="text" class="form-control" name="answer-`+i+`-`+a+`" required autocomplete="answer-`+a+`">
                    </div>
                </div>`
        document.getElementById("question-container-" + i).insertAdjacentHTML('beforeend', x);
    }
}
