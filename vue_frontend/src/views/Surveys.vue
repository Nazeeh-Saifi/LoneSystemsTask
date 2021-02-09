<template>
  <b-container class="list-surveys">
    <b-row>
      <b-col>
        <b-card header-tag="header" footer-tag="footer" align="left">
          <template #header>
            <h6 class="mb-0">Surveys List:</h6>
          </template>
          <b-table hover outlined stacked="md" :items="items" :fields="fields">
            <template #cell(index)="data">
              {{ data.index + 1 }}
            </template>
            <template #cell(take)="data">
              <b-button @click="takeSurvey(data.item.id)" variant="primary">
                <b-icon icon="card-checklist"> </b-icon>
              </b-button>
            </template>
            <template #cell(view)="data">
              <b-button
                @click="viewSubmissions(data.item.id)"
                variant="success"
              >
                <b-icon icon="layers"> </b-icon>
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
  name: "Surveys",
  data() {
    return {
      fields: [
        "index",
        "Title",
        { key: "take", label: "Take Survey" },
        { key: "view", label: "View Submissions" },
      ],

      items: [],
    };
  },
  methods: {
    getSurveys() {
      let self = this;
      axios
        .get(this.$apiAdress + "/api/surveys")
        .then(function (response) {
          console.log(response);
          self.items = response.data.surveys;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    takeSurvey(id) {
      this.$router.push({
        name: `TakeSurvey`,
        params: { id },
      });
    },
    viewSubmissions(id) {
      this.$router.push({
        name: "Submissions",
        params: { id },
      });
    },
    goBack() {
      this.$router.go(-1);
    },
  },
  mounted() {
    this.getSurveys();
  },
};
</script>

<style>
</style>