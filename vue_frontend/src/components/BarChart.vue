<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,

  props: {
    chartdata: {
      type: Object,
      default: null,
    },
    options: {
      type: Object,
      default: null,
    },
  },
  mounted() {
    this.renderChart(this.chartdata, this.options);
    // console.log("the data when rendering the chart:", this.chartData);
  },
};
</script>
