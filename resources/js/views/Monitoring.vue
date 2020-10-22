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
                        FULLNAME: <div class="title text-uppercase">{{ indexedItems[0].fullname }}</div>
                    </v-col>
                    <v-col cols="12" sm="12" md="3">
                        TEMPERATURE: <div class="title text-uppercase">{{ indexedItems[0].Temperature }}</div>
                    </v-col>
                    <v-col cols="12" sm="12" md="3">
                        TIMESTAMP: <div class="title text-uppercase">{{ indexedItems[0].DateCreated }}</div>
                    </v-col>
                    <v-col cols="12" sm="12" md="3">
                        CURRENT TIME: <div class="title text-uppercase">{{ indexedItems[0].DateCreated }}</div>
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
                        value: 'Office',
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
                ...item
            }))
        }
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

    },
    mounted(){
        this.loadTransactions();

        this.refreshInterval = setInterval(function(){
            this.refreshTransactions();
            console.log('refreshed...')
        }.bind(this), 3000);
    },
    beforeDestroy(){
        clearInterval(this.refreshInterval);
    }
}
</script>