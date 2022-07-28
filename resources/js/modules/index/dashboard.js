import Vue, {createApp} from 'vue';
import Vue3Apexcharts from "vue3-apexcharts";

const DashboardComponent = {
    components: {
        apexchart: Vue3Apexcharts
    },
    data() {
        return {
            loading: true,
            tabularData: [],
            series: [],
            chartOptions: {
                chart: {
                    type: 'pie',
                },
                labels: [],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }
        }
    },
    methods: {},
    mounted() {
        let that = this;
        let config = {
            method: 'GET',
            url: '/rest/dashboard'
        }

        let result = axios(config);
        result.then((data) => {
            that.series = data.data.chart01.series;
            that.chartOptions = {
                labels: data.data.chart01.labels
            }
            that.tabularData = data.data.table01;
            that.loading = false;
        })
    }
}


let app = createApp(DashboardComponent)
app.mount('#content');
