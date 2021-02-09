<template>
  <b-container>
    <b-row>
      <b-col>
        <b-card>
          <template #header>
            <div>
              <h4>L-one Systems Task:</h4>
            </div>
          </template>

          <h5>#in order to run this project please follow the instructions:</h5>
          <b-row>
            <b-col>
              <b-card>
                <!-- TODO: Complete the instructions -->
                <h6>running the backend(lOneSystemsApp):</h6>
                <ol>
                  <li>copy (.env.example) file and rename it (.env)</li>
                  <li>
                    insert your database credentials and mail configuration (
                    I've used mailtrap to test sending emails )
                  </li>
                  <li>
                    open terminal and navigate to lOneSystemsApp directory
                  </li>
                  <li>
                    run the following commands:
                    <ul>
                      <li>composer install</li>
                      <li>
                        php artisan key:generate
                        <b>(important step for encryption)</b>
                      </li>
                      <li>php artisan migrate</li>
                      <li>php run serve</li>
                      <li>the backend should be Up & Running!</li>
                    </ul>
                  </li>
                </ol>

                <h6>running the frontend(vue_frontend):</h6>
                <ol>
                  <li>open terminal and navigate to vue_frontend directory</li>
                  <li>
                    run the following commands:
                    <ul>
                      <li>npm install</li>
                      <li>npm run serve</li>
                      <li>the frontend should be Up & Running!</li>
                    </ul>
                  </li>
                </ol>
                <p>
                  <b>Note:</b>please make sure that the backend api is running
                  on this address: http://127.0.0.1:8000 otherwise you need
                  specify the address in vue_frontend/src/main.js
                </p>
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