<template>
  <b-container class="list-surveys">
    <b-row>
      <b-col>
        <b-card header-tag="header" footer-tag="footer" align="left">
          <template #header>
            <h6 class="mb-0">survey with id:{{ SurveyId }} submissions:</h6>
          </template>
          <b-table
            hover
            outlined
            stacked="md"
            :items="submissions"
            :fields="fields"
          >
            <template #cell(index)="data">
              {{ data.index + 1 }}
            </template>
          </b-table>

          <template #footer>
            <b-button @click="goBack()" variant="danger" class="mr-2">
              Go Back
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
  name: "Submissions",
  data() {
    return {
      SurveyId: this.$route.params.id,
      SurveyTitle: null,
      submissions: [],

      fields: ["index", "Title"],
    };
  },
  methods: {
    getSubmissions() {
      let self = this;
      axios
        .get(this.$apiAdress + "/api/surveys/" + this.SurveyId)
        .then((response) => {
          console.log(response);
          self.submissions = response.data.survey.submissions;
          self.SurveyTitle = response.data.survey.Title;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    goBack() {
      this.$router.go(-1);
    },
  },
  mounted() {
    this.getSubmissions();
  },
};
</script>

<style>
</style>