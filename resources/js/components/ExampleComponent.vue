<template>
  <div class="col-md-10 mb-2">
    <div class="d-flex justify-content-end">
      <button v-if="!startQuiz && results === null" v-on:click="getQuestions()" class="btn btn-secondary">Start Quiz</button>
    </div>
  </div>
  <div v-if="results !== null" class="col-md-10">
    <div class="card mb-4">
      <div class="card-header">Results</div>
      <div class="card-body">
        <div class="list-group mb-4">
          <a href="javascript:void(0)"
             class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <p class="mb-1">Obtained Marks</p>
              <p class="mb-1">{{results.marks}}</p>
            </div>
            <div class="d-flex w-100 justify-content-between">
              <p class="mb-1">Attempted Questions</p>
              <p class="mb-1">{{answers.length}}</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div v-if="startQuiz" class="col-md-10">
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
          <h3>Quiz</h3>
          <vue-countdown :time="quiz.time * 60 * 1000" v-slot="{ days, hours, minutes, seconds }"
                         @end="submitQuiz()">
            Time Remaining: {{ minutes }} minutes, {{ seconds }} seconds.
          </vue-countdown>
        </div>
      </div>

      <div class="card-body">
        <form @submit.prevent="submitQuiz()" method="post">
          <div class="list-group mb-4">
            <a v-for="question in questions" href="javascript:void(0)"
               class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{ question.question }}</h5>
              </div>
              <div v-for="answer in question.answers" class="d-flex w-100 justify-content-start">
                <div class="form-check">

                  <input type="radio" class="form-check-input" :name="'question-'+question.id"
                         :id="'answer-'+question.id+'-'+answer.id" :value="answer.id" v-on:click="submitAnswer(answer.id, question.id)">
                  <label class="form-check-label" :for="'answer-'+question.id+'-'+answer.id">{{ answer.answer }}</label>
                </div>
              </div>
            </a>
          </div>
          <div class="d-flex w-100 justify-content-end">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['quiz', 'ans', 'result'],
  data() {
    return {
      startQuiz: false,
      questions: [],
      results: [],
      answers: [],
    }
  },
  created() {
    this.results = this.result
    this.answers = this.ans
  },
  mounted() {
  },
  methods: {
    async getQuestions() {
      let self = this
      // await fetch('/api/quiz/questions?quiz_id='+this.quiz.id)
      //   .then((response) => response.json())
      //   .then(function (data) {
      //     self.questions = data
      //     console.log(data, self.questions)
      //   });
      const response = await fetch('/api/quiz/questions?quiz_id=' + this.quiz.id);
      const data = await response.json();
      this.questions = data.ques;
      this.startQuiz = true
    },
    async getResults() {
      let self = this
      const requestOptions = {
        method: "GET",
        headers: {"Content-Type": "application/json",
          "X-CSRF-Token": document.head.querySelector("[name~=csrf-token][content]").content,
        },
      };
      const response = await fetch('/quiz/results?quiz_id=' + this.quiz.id, requestOptions);
      const data = await response.json();
      this.results = data.result
      this.answers = data.ans
      this.startQuiz = false
      this.quiz.time = 0
    },
    onCountdownEnd() {
      this.submitQuiz();
    },
    submitAnswer(answer, question) {
      this.submitChooseAnswer(answer, question)
    },
    async submitChooseAnswer(answer, question) {
      const requestOptions = {
        method: "POST",
        headers: {"Content-Type": "application/json",
          "X-CSRF-Token": document.head.querySelector("[name~=csrf-token][content]").content,
        },
        body: JSON.stringify({answer: answer, question: question})
      };
      const response = await fetch("/quiz/answer/submit", requestOptions);
    },
    async submitQuiz() {
      await this.getResults()
    },
  },
}
</script>
