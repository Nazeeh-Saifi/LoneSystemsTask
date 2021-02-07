<template>
  <b-container class="list-surveys">
    <b-row style="text-align: center">
      <b-col sm="12" class="mb-3">
        <b-card align="center">
          <transition
            mode="out-in"
            enter-active-class="animate__animated animate__fadeInLeft"
            leave-active-class="animate__animated animate__fadeOutRight"
          >
            <div v-if="showQuestion" class="p-5">
              <h4 class="font-weight-bold">Question #{{ counter }}:</h4>
              <h5>{{ question.Body }}</h5>
            </div>
          </transition>
          <transition
            mode="out-in"
            enter-active-class="animate__animated animate__fadeInLeft animate__delay-2s"
            leave-active-class="animate__animated animate__fadeOutRight"
            class="finish"
          >
            <div v-if="finished" class="p-5">
              <h2>you've completed the survey!</h2>
              <p>here is your answers you can edit them before submitting.</p>

              <b-form-group
                v-for="(answer, index) in answers"
                :key="index"
                :label="answer.QuestionTitle"
                v-slot="{ ariaDescribedby }"
              >
                <b-form-radio
                  v-model="answer.Answer"
                  :aria-describedby="ariaDescribedby"
                  :name="index"
                  :value="true"
                  >Yes</b-form-radio
                >
                <b-form-radio
                  v-model="answer.Answer"
                  :aria-describedby="ariaDescribedby"
                  :name="index"
                  :value="false"
                  >No</b-form-radio
                >
              </b-form-group>
            </div>
          </transition>
          <template #footer>
            <b-row style="justify-content: space-evenly">
              <b-button
                @click="saveAnswer(false)"
                variant="danger"
                class="mr-2"
                v-if="!finished"
              >
                No
              </b-button>
              <b-button
                @click="saveAnswer(true)"
                variant="success"
                class="mr-2"
                v-if="!finished"
              >
                Yes
              </b-button>
              <b-button
                @click="goBack()"
                variant="danger"
                class="mr-2"
                v-if="finished"
              >
                Go Home
              </b-button>
              <b-button
                @click="store()"
                variant="success"
                class="mr-2"
                v-if="finished"
              >
                Submit
              </b-button>
            </b-row>
          </template>
        </b-card>
      </b-col>
      <b-col sm="12" v-if="!finished">
        <b-button
          pill
          @click="toggleNote()"
          variant="outline-dark"
          class="m-2"
          v-b-tooltip.hover
          title="this will toggle text area for notes"
        >
          <b-icon icon="patch-plus" v-if="!showNote"> </b-icon>

          <b-icon-patch-minus v-if="showNote"> </b-icon-patch-minus>
        </b-button>
      </b-col>
      <b-col sm="12" v-if="!finished">
        <b-form-textarea
          id="input-1"
          v-if="showNote"
          v-model="note"
          placeholder="Enter something..."
          rows="3"
          max-rows="6"
        ></b-form-textarea>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import axios from "axios";
export default {
  name: "TakeSurvey",
  data() {
    return {
      surveyId: this.$route.params.id,
      counter: 1,
      question: {
        //id
        //body
        //yesId
        //NoId
      },
      note: null,
      showNote: false,
      followUp: false,
      nextId: null,
      showQuestion: true,
      answers: [
        // {
        //   //QuestionId:
        //   //
        // },
      ],
      finished: false,
    };
  },
  methods: {
    store() {
      const formData = new FormData();
      formData.set("SurveyId", this.surveyId);
      formData.set("Answers", JSON.stringify(this.answers));

      console.log(this.answers);
      axios
        .post(this.$apiAdress + "/api/submissions", formData)
        .then(function (response) {
          console.log(response);
          //TODO show alert
          // self.goBack();
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    saveAnswer(result) {
      console.log(result);
      this.showQuestion = false;
      const answer = {};
      answer["QuestionId"] = this.question.id;
      answer["Answer"] = result;
      answer["QuestionTitle"] = this.question.Body;
      answer["Note"] = this.note;
      this.answers.push(answer);
      this.note = null;
      // if(!this.question.YesQuestionId && !this.question.NoQuestionId){
      //   this.getNextQuestion()
      // }

      if (result == true && this.question.YesQuestionId) {
        console.log("yes follow up");
        this.getFollowUpQuestion(this.question.YesQuestionId);
      } else if (result == false && this.question.NoQuestionId) {
        console.log("no follow up");
        this.getFollowUpQuestion(this.question.NoQuestionId);
      } else {
        console.log("next question");
        this.getNextQuestion(this.surveyId, this.nextId);
      }
    },
    getFirstQuestion() {
      let self = this;
      axios
        .get(
          this.$apiAdress +
            "/api/surveys/" +
            this.surveyId +
            "/getFirstQuestion"
        )
        .then((response) => {
          console.log(response);
          self.question = response.data.question;
          self.nextId = this.nextQuestionId();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getFollowUpQuestion(questionId) {
      let self = this;
      axios
        .get(this.$apiAdress + "/api/questions/" + questionId)
        .then((response) => {
          console.log(response);
          self.followUp = true;
          self.question = response.data.question;
          self.showQuestion = true;
          self.counter++;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getNextQuestion(surveyId, nextQuestionId) {
      let self = this;
      axios
        .get(
          this.$apiAdress +
            "/api/surveys/" +
            surveyId +
            "/questions/" +
            nextQuestionId
        )
        .then((response) => {
          console.log(response);
          self.question = response.data.question;
          if (response.data.message == "end of survey") {
            self.finished = true;
          } else {
            self.followUp = false;
            self.nextId = this.nextQuestionId();
            self.showQuestion = true;
            self.counter++;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    nextQuestionId() {
      if (this.question.YesQuestionId && this.question.NoQuestionId)
        return this.question.id + 3;
      else if (this.question.YesQuestionId || this.question.NoQuestionId)
        return this.question.id + 2;
      else return this.question.id + 1;
    },
    toggleNote() {
      if (this.showNote) {
        this.showNote = false;
      } else {
        this.showNote = true;
      }
    },
    goBack() {
      this.$router.push({ name: "Home" });
    },
  },
  mounted() {
    this.getFirstQuestion();
  },
};
</script>

<style scoped>
</style>