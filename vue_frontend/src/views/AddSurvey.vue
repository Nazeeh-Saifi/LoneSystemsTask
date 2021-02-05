<template>
  <b-container class="create-product">
    <b-row>
      <b-col>
        <b-card header-tag="header" footer-tag="footer" align="left">
          <template #header>
            <div>
              <h6 class="mb-0">create new Survey:</h6>
            </div>
          </template>

          <b-form-group
            id="fieldset-0"
            description="Let us know title of the survey."
            label="Enter Survey Title:"
            label-for="input-0"
            valid-feedback="Thank you!"
            :invalid-feedback="invalidFeedback0"
            :state="validation0"
          >
            <b-form-input
              id="input-0"
              v-model="form.title"
              :state="validation0"
              trim
              :type="'text'"
            ></b-form-input>
          </b-form-group>

          <b-card
            class="question-card mb-4"
            v-for="(question, index) in form.questions"
            :key="index"
            align="left"
          >
            <div :role="'group' + (index + 1)">
              <b-row>
                <b-col lg="11">
                  <label :for="'input-' + (index + 1)"
                    >Enter question number {{ index + 1 }}
                  </label>
                </b-col>

                <b-col lg="1" v-if="form.questions.length > 1">
                  <b-icon-x
                    style="cursor: pointer"
                    @click="deleteQuestion(index)"
                  ></b-icon-x>
                </b-col>

                <b-col lg="12">
                  <b-form-input
                    :id="'input-' + (index + 1)"
                    v-model="form.questions[index].body"
                    aria-describedby="input-live-help input-live-feedback"
                    trim
                  >
                  </b-form-input>

                  <!--  <b-form-invalid-feedback
                    :id="'input-' + (index + 1) + '-feedback'"
                  >
                    Enter at least 4 letters
                  </b-form-invalid-feedback>
                  <b-form-text :id="'input-' + (index + 1) + '-help'">
                    let us know your #{{ index + 1 }} question
                  </b-form-text> -->
                </b-col>
              </b-row>
              <b-row style="justify-content: center">
                <b-button
                  pill
                  @click="toggleFollowUpQuestions(index)"
                  variant="outline-dark"
                  class="m-2"
                  v-b-tooltip.hover
                  title="this will add yes/no follow up questions"
                >
                  <b-icon icon="patch-plus" v-if="!form.questions[index].show">
                  </b-icon>

                  <b-icon-patch-minus v-if="form.questions[index].show">
                  </b-icon-patch-minus>
                </b-button>
              </b-row>
              <b-row>
                <b-col lg="12">
                  <b-card
                    v-if="form.questions[index].show"
                    border-variant="success"
                    header-bg-variant="success"
                    align="center"
                    class="mb-4"
                  >
                    <b-form-input
                      :id="'input-yes-' + (index + 1)"
                      v-model="form.questions[index].yesQuestion"
                      aria-describedby="input-live-help input-live-feedback"
                      trim
                      aria-placeholder="Enter yes questions"
                      placeholder="Enter yes question"
                    >
                    </b-form-input>
                  </b-card>
                </b-col>

                <b-col lg="12">
                  <b-card
                    v-if="form.questions[index].show"
                    border-variant="danger"
                    header-bg-variant="danger"
                    align="center"
                    class="mb-4"
                  >
                    <b-form-input
                      :id="'input-no-' + (index + 1)"
                      v-model="form.questions[index].noQuestion"
                      aria-describedby="input-live-help input-live-feedback"
                      trim
                      aria-placeholder="Enter no question"
                      placeholder="Enter no question"
                    >
                    </b-form-input>
                  </b-card>
                </b-col>
              </b-row>
            </div>
          </b-card>

          <b-row>
            <b-col lg="4">
              <b-button
                id="next-question-btn"
                @click="addNextQuestion()"
                variant="warning"
                class="m-2"
                pill
              >
                Add Next Question
              </b-button>
            </b-col>
          </b-row>

          <template #footer>
            <b-button @click="goBack()" variant="danger" class="mr-2">
              Go Home
            </b-button>

            <b-button
              v-if="active"
              @click="store()"
              variant="primary"
              class="mr-2"
            >
              Save
            </b-button>

            <b-button
              v-if="!active"
              variant="secondary"
              class="mr-2"
              v-b-tooltip.hover
              title="this will activate when you enter a title and 1 question at least"
            >
              Save
            </b-button>
          </template>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import axios from "axios";
export default {
  name: "AddSurvey",
  data() {
    return {
      index: 1,
      form: {
        title: "",
        questions: [
          {
            // id: 1,
            body: "",
            show: false,
            yesQuestion: null,
            noQuestion: null,
          },
        ],
      },
    };
  },
  computed: {
    validation0() {
      return this.form.title.length > 4;
    },
    invalidFeedback0() {
      if (this.form.title.length <= 4 && this.form.title.length > 0) {
        return "Enter at least 4 letters.";
      }
      return "Please enter something.";
    },
    globalValidation1() {
      return this.form.questions[0].body.length > 4;
    },

    active() {
      return this.validation0 && this.questionsValidation;
    },
    questionsValidation() {
      return this.form.questions.filter((q) => q.body).length > 0;
    },
  },
  methods: {
    addNextQuestion() {
      this.form.questions.push({
        // id: this.form.questions.length + 1,
        body: "",
        show: false,
        yesQuestion: null,
        noQuestion: null,
      });

      // create a computed property dynamically
      this.$options.computed["validation" + this.index] = {
        get() {
          return this.form.questions[this.index].body.length > 10;
        },
      };
      console.log(this.$options.computed);
    },
    toggleFollowUpQuestions(index) {
      if (this.form.questions[index].show) {
        this.form.questions[index].show = false;
      } else {
        this.form.questions[index].show = true;
      }
    },
    deleteQuestion(index) {
      this.form.questions.splice(index, 1);
    },

    goBack() {
      this.$router.push({ name: "Home" });
    },
    store() {
      const formData = new FormData();
      formData.set("Title", this.form.title);
      formData.set(
        "Questions",
        JSON.stringify(this.form.questions.filter((q) => q.body))
      );

      console.log(this.form);
      // let self = this;
      axios
        .post(this.$apiAdress + "/api/surveys", formData)
        .then(function (response) {
          console.log(response);
          // self.goBack();
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.question-card {
  background-color: #f7f7f7 !important;
}
</style>
