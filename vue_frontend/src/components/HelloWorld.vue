<template>
  <b-container>
    <b-row>
      <b-col>
        <b-card>
          <template #header>
            <div>
              <h3>L-one Systems Task:</h3>
            </div>
          </template>

          <h5>#in order to run this project please follow the instructions:</h5>
          <b-row>
            <b-col>
              <b-card>
                <!-- TODO: Complete the instructions -->
                <ol>
                  <li>add .env file and insert your database credentials</li>
                </ol>
              </b-card>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-card>
          <!-- TODO: Complete the instructions -->
          <b-row>
            <b-col lg="6">
              <BarChart
                v-if="loaded"
                :chartdata="chartdata"
                :options="options"
              ></BarChart>
            </b-col>
            <b-col lg="6">
              <BarChart
                v-if="loaded2"
                :chartdata="chartdata2"
                :options="options"
              ></BarChart>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import BarChart from "./BarChart.vue";
import axios from "axios";
export default {
  name: "HelloWorld",
  components: {
    BarChart,
  },
  data() {
    return {
      year: "2021",
      chartdata: null,
      chartdata2: null,
      loaded: false,
      loaded2: false,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
            },
          ],
        },
      },
    };
  },
  methods: {
    getSubmissionsPerMonth() {
      this.loaded = false;
      let self = this;
      axios
        .get(this.$apiAdress + "/api/getSubmissionsPerMonth")
        .then((response) => {
          console.log(response);
          // self.$set(
          //   self.chartdata,
          //   "labels",
          //   response.data.monthYearOfSumbissionString
          // );

          self.chartdata = {
            labels: response.data.monthYearOfSumbission,
            datasets: [
              {
                label: "number of submissions per month",
                backgroundColor: "#7986F8",
                data: response.data.submissionsCounter,
              },
            ],
          };
          self.loaded = true;

          // self.chartdata.labels = response.data.monthYearOfSumbissionString;
          // self.chartdata.datasets[0].data =
          //   response.data.numberOfSubmissionString;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getSubmissionsPerSurvey() {
      this.loaded2 = false;

      let self = this;
      axios
        .get(this.$apiAdress + "/api/getSubmissionsPerSurvey")
        .then((response) => {
          console.log(response);

          self.chartdata2 = {
            labels: response.data.surveysTitles,
            datasets: [
              {
                label: "number of submissions per survey",
                backgroundColor: "#f87979",
                data: response.data.surveysNumberOfSubmissions,
              },
            ],
          };
          self.loaded2 = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getSubmissionsPerMonth();
    this.getSubmissionsPerSurvey();
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
ul {
  padding: 0;
}
li {
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>