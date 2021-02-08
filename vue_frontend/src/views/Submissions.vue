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
            <template #cell(exportcsv)="data">
              <b-button @click="exportCsv(data.item.id)" variant="success">
                <b-icon icon="arrow-down"> </b-icon>
              </b-button>
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

      fields: ["index", "Title", "ExportCsv"],
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
    exportCsv(submId) {
      const desiredSubm = this.submissions.filter(
        (submission) => submission.id == submId
      );
      console.log("desiredsubm:", desiredSubm);
      const jsonData = desiredSubm[0].questions.map((question) => ({
        SurveyId: this.SurveyId,
        SurveyTitle: this.SurveyTitle,
        QuestionId: question.id,
        Question: question.Body,
        Answer: question.pivot.Answer == 0 ? "No" : "Yes",
      }));
      console.log("json:", jsonData);

      let csvContent = "data:text/csv;charset=utf-8,";
      csvContent += [
        Object.keys(jsonData[0]).join(","),
        ...jsonData.map((item) => Object.values(item).join(",")),
      ]
        .join("\n")
        .replace(/(^\[)|(\]$)/gm, "");

      console.log(csvContent);

      const data = encodeURI(csvContent);
      const link = document.createElement("a");
      link.setAttribute("href", data);
      link.setAttribute("download", "submisstion" + submId + "export.csv");
      link.click();
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