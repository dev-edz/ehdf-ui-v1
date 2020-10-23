<template>
    <div id="Monitoring">
       <v-container fluid>
        <v-card class="mx-auto my-3 floating" outlined>
            <v-card-title class="green pa-2 ma-2 white--text justify-center">
                LATEST LOG
            </v-card-title>
            <v-card-text>
                <v-row v-if="indexedItems[0]">
                    <v-col cols="12" sm="12" md="3">
                        FULLNAME: <div class="title text-uppercase font-weight-black">{{ indexedItems[0].fullname }}</div>
                    </v-col>
                    <v-col cols="12" sm="12" md="3">
                        TEMPERATURE: <div class="title text-uppercase font-weight-black">{{ indexedItems[0].Temperature }}</div>
                    </v-col>
                    <v-col cols="12" sm="12" md="3">
                        TIMESTAMP: <div class="title text-uppercase font-weight-black">{{ indexedItems[0].DateCreated }}</div>
                    </v-col>
                    <v-col cols="12" sm="12" md="3">
                        CURRENT TIME: <div class="title text-uppercase font-weight-black">{{ realtimeClock }}</div>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-card class="mx-auto" outlined>
            <v-card-title class="green pa-2 ma-2 white--text justify-center">DATA LOG</v-card-title>
            <v-card-text>
                <v-data-table
                    class="table-striped text-uppercase"
                    :headers="dataTable.headers"
                    :items="indexedItems"
                    :loading="loading"
                    :items-per-page="-1"
                    hide-default-footer
                    fixed-header
                    hover
                    outline
                >
                </v-data-table>
            </v-card-text>
        </v-card>
       </v-container>
    </div>
</template>
<script>
export default {
    data(){
        return {
            loading: false,
            realtimeClock: '',
            clockInterval: '',
            dataTable: {
                headers: [
                    {
                        text: 'No',
                        align: 'center',
                        sortable: false,
                        value: 'id',
                        divider: true,
                        width: '10%',
                    },
                    {
                        text: 'Fullname',
                        align: 'start',
                        sortable: false,
                        value: 'fullname',
                        divider: true
                    },
                    {
                        text: 'Office',
                        align: 'center',
                        sortable: false,
                        value: 'UserOffice',
                        divider: true
                    },
                    {
                        text: 'Date & Time',
                        align: 'center',
                        sortable: true,
                        value: 'DateCreated',
                        divider: false,
                        width: '20%',
                    },
                ],
                items: [],
                refreshInterval: '',
            }
        }
    },
    computed: {
        indexedItems () {
            return this.dataTable.items.map((item, index) => ({
                id: index + 1,
                fullname: item.USERFULLNAME || (item.FirstName + ' ' + item.MiddleName + ' ' + item.LastName + ' ' + item.SuffixName),
                UserOffice: item.UserInfoID ? 'Philippine Overseas Employment Administration (POEA)' : item.Office,
                ...item
            }))
        },
    },
    methods: {
        loadTransactions(){
            this.loading = true;
            window.vue.prototype.$http.get('/api/transactions')
            .then(response => {
                this.dataTable.items = response.data;
                // this.dataTable.items["DateCreated"] = response.data["DateCreated"]
                this.loading = false;
                // console.log(response.data);
            }).catch(error => {
                console.log(error);
            })
        },
        refreshTransactions(){
            window.vue.prototype.$http.get('/api/transactions')
            .then(response => {
                this.dataTable.items = response.data;
            }).catch(error => {
                console.log(error);
            })
        },
        getCurrentTime(){
            var self = this;
            this.clockInterval = setInterval(function(){
                var today = new Date();
                self.realtimeClock = self.format12Hour(today);
                // var h = today.getHours();
                // var m = today.getMinutes();
                // var s = today.getSeconds();
                // m = self.checkTime(m);
                // s = self.checkTime(s);
                // self.realtimeClock = h + ":" + m + ":" + s;
            }, 500);
        },
        checkTime(t){
            if (t < 10) {t = "0" + t};  // add zero in front of numbers < 10
            return t;
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
        }

    },
    mounted(){
        this.getCurrentTime();
        this.loadTransactions();

        this.refreshInterval = setInterval(function(){
            this.refreshTransactions();
            console.log('refreshed...')
        }.bind(this), 3000);
    },
    beforeDestroy(){
        clearInterval(this.refreshInterval);
        clearInterval(this.clockInterval);
    }
}
</script>