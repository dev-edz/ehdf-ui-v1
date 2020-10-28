<template>
    <div>
        <v-row fluid class="px-3" dense>
            <v-col cols="12" sm="12" md="4"
                v-for="(menu, index) in dashboard.menus" :key="index"
                >
                
                <v-card 
                    :color="menu.color"  
                    outlined 
                    hover
                    :to="menu.link"
                >

                    <v-skeleton-loader
                        v-if="!loading"
                        class="mx-auto"
                        type="card"
                        max-height="170px"
                    ></v-skeleton-loader>

                    <v-card-title v-if="loading">
                        <!-- <v-icon
                            class=" mr-4"
                            size="38"
                        >
                            {{ menu.icon }}
                        </v-icon> -->
                        <span class="text-uppercase title font-weight-black white--text">
                            {{ menu.title }}
                        </span>
                        
                        <v-spacer></v-spacer>
                        <div class="title font-weight-black white--text">
                            <strong>{{ menu.counter }}</strong>
                        </div>
                    </v-card-title>

                    
                    <v-sparkline 
                        v-if="loading"
                        :value="menu.values"
                        :labels="menu.labels"
                        class="ma-2"
                        color="rgba(255, 255, 255, .7)"
                        height="75"
                        padding="18"
                        stroke-linecap="round"
                        auto-draw
                        type="trend"
                    >
                    </v-sparkline>
                </v-card>
            </v-col>
        </v-row>
        <v-row fluid>
            <v-col>
                <v-card outlined class="ma-0">
                    <!-- <v-card-title class="green pa-2 ma-2 white--text justify-center">
                        LATEST LOG
                    </v-card-title> -->
                    <v-skeleton-loader
                        v-if="!loading"
                        class="mx-auto"
                        type="card"
                    ></v-skeleton-loader>
                    <v-card-text v-if="loading">
                        <v-row v-for="(log, index) in latestLog" :key="index">
                            <v-col>
                                <div class="d-flex justify-center font-weight-black text-uppercase">{{ log.title }}</div>
                                <div class="d-flex justify-center display-2 font-weight-black text-uppercase">{{ log.value }}</div>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <div class="d-flex justify-center font-weight-black text-uppercase">Current Time</div>
                                <div class="d-flex justify-center display-2 font-weight-black text-uppercase">{{ realtimeClock }}</div>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    data(){
        return {
            loading: false,
            dashboard: {
                menus: [
                    { title: 'Registered Users', icon: 'mdi-account-group', link: '#', counter: 0, color: 'blue darken-4', values: [], labels: [] },
                    { title: 'New Users', icon: 'mdi-account-details', link: '#', counter: 0, color: 'green', values: [], labels: [] },
                    { title: 'Transactions', icon: 'mdi-format-list-text', link: '/monitoring', counter: 0, color: 'orange', values: [], labels: [] },
                ],
                // infoGraphics: "www.github.com/dev-edz/ehdf-ui-v1/blob/master/resources/img/eHDF-Infographics.png"
                infoGraphics: "../../img/ehdf_info2.png"
            },
            latestLog: [
                { title: 'Fullname', value: ''},
                { title: 'Temperature', value: '' },
                { title: 'Timestamp', value: '' },
            ],
            realtimeClock: '',
            clockInterval: '',
            refreshInterval: '',
        }
    },
    computed: {
        latestLogFormatter(){

        }
    },
    methods: {
        loadPersons(){
        this.loading = true,
            window.vue.prototype.$http.get('/api/persons')
            .then(response => {
                this.dashboard.menus[0].counter = response.data.length;
            }).catch(error => {
                console.log(error);
            })
        },
        loadTransactions(){
            window.vue.prototype.$http.get('/api/transactions')
            .then(response => {
                this.dashboard.menus[2].counter = response.data.length;
            }).catch(error => {
                console.log(error);
            })
        },
        loadPersonsSummary(){
            window.vue.prototype.$http.get('/api/persons')
            .then(response => {
                window.vue.prototype.$http.get('/api/summary/persons')
                .then(res => {
                    for (const item of Object.entries(res.data)) {
                        this.dashboard.menus[0].labels.push(item[0]);
                        this.dashboard.menus[0].values.push(item[1].length);
                    }

                    console.log('persons summary...success')
                }).catch(error => {
                    console.log('error here 2...', error)
                });

            }).catch(error => {
                console.log('error here 1...')
            });
        },
        loadTransactionsSummary(){
            window.vue.prototype.$http.get('/api/summary/transactions')
            .then(res => {
                var i = [];
                for (const item of Object.entries(res.data)) {
                    this.dashboard.menus[2].labels.push('..');
                    this.dashboard.menus[2].values.push(item[1].length);
                    i.push(item[0])
                }
                
                this.dashboard.menus[2].labels[0] = i[0];
                this.dashboard.menus[2].labels[i.length - 1] = i[i.length - 1];
            }).catch(error => {
                console.log('error @ transaction summary', error)
            });
        },
        loadNewPersons(){

            window.vue.prototype.$http.get('/api/newpersons')
            .then(response => {
                this.dashboard.menus[1].counter = response.data.length;
                window.vue.prototype.$http.get('/api/summary/newpersons')
                .then(res => {
                    let i = 1;
                    for (const item of Object.entries(res.data)) {
                        this.dashboard.menus[1].labels.push(item[0]);
                        this.dashboard.menus[1].values.push(i);
                        i += 1;
                    }
                    console.log('new persons...success')
                }).catch(error => {
                    console.log('error @ new persons', error)
                });
            }).catch(error => {
                console.log(error);
            });
            
        },
        getCurrentTime(){
            var self = this;
            this.clockInterval = setInterval(function(){
                var today = new Date();
                self.realtimeClock = self.format12Hour(today);
            }, 500);
        },
        format12Hour(date){
            var h = date.getHours();
            var m = date.getMinutes();
            var s = date.getSeconds();
            var ampm = h >= 12 ? 'pm' : 'am';

            h = h % 12;
            h = h ? h : 12;
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;

            var currentTime = h + ':' + m + ':' + s + ' ' + ampm;
            return currentTime;
        },
        loadLatest(){
            this.loading = true;
            window.vue.prototype.$http.get('/api/latest')
            .then(response => {
                let user = response.data[0];
                this.latestLog[0].value = user.USERFULLNAME || (user.FirstName + ' ' + user.MiddleName + ' ' + user.LastName + ' ' + user.SuffixName);
                this.latestLog[1].value = user.Temperature + "°C";
                this.latestLog[2].value = user.DateCreated;
            }).catch(error => {
                console.log(error);
            });
        }
        
    },
    mounted(){
        this.getCurrentTime();
        this.loadPersons();
        this.loadNewPersons();
        this.loadTransactions();
        this.loadPersonsSummary();
        this.loadTransactionsSummary();
            

        this.refreshInterval = setInterval(function(){
            this.loadLatest();
            console.log('refreshed...')
        }.bind(this), 3000);

        this.loading = false;
    },
    beforeDestroy(){
        clearInterval(this.clockInterval);
        clearInterval(this.refreshInterval);
    }
}
</script>
<style>  
    img {
        max-width: 100%;
        max-height: 100%;
        /* display: block; remove extra space below image */
    }
</style>