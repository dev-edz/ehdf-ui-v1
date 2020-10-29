<template>
    <div>
        <v-row no-gutters class="mb-2">
            <v-col cols="12" sm="12" md="3" class="d-flex py-0">
                <v-text-field
                    class="font-weight-bold"
                    v-model="search"
                    outlined
                    dense
                    clearable
                    label="Search User..."
                    prepend-inner-icon="mdi-magnify">
                </v-text-field>
            </v-col>
            <v-col cols="12" sm="12" md="6" offset-md="3" class="d-md-flex justify-md-end">
                
                <div class="mr-md-2 mb-2">
                    <v-btn
                        v-if="selectingUserInfo" 
                        text 
                        md12 
                        block
                        color="error"
                        @click="handleClearSelection();"
                    >
                        Clear Selection
                    </v-btn>
                </div>
                <div class="mr-md-2 mb-2">
                    <download-excel
                        v-if="selectingUserInfo"
                        :data="selectedUserInfo"
                        :fields="indexedHeaders"
                        name= 'downloaded_hdf_data.xls'>
                        <v-btn 
                            block
                            outlined 
                            sm12
                            color="warning"
                        >
                            Download ({{ this.selectedUserInfo.length }})
                        </v-btn>
                    </download-excel>
                </div>
                <div class="mr-md-2 mb-2">
                    <v-btn 
                        block
                        outlined 
                        sm12
                        @click="refreshUserInfo()"
                    >
                        Refresh
                        <v-icon
                            right
                            dark
                        >
                            mdi-refresh
                        </v-icon>
                    </v-btn>
                </div>
                <div>
                    <download-excel 
                        :data="indexedItems"
                        :fields="indexedHeaders"
                        name= 'downloaded_hdf_data.xls'>
                        <v-btn 
                            block
                            depressed 
                            sm12 
                            color="warning"
                        >
                            Download All
                        </v-btn>
                    </download-excel>
                </div>
            </v-col>
        </v-row>

        <v-data-table
            ref="dtUserInfo"
            class="table-striped text-uppercase"
            :headers="dataTable.headers"
            :items="indexedItems"
            :loading="loading"
            :items-per-page="-1"
            :search="search"
            hide-default-footer
            fixed-header
            height="70vh"
            @click:row="handleRowClick"
        >
            
        </v-data-table>
    </div>
</template>
<script>
export default {
    data(){
        return {
            search: '',
            loading: false,
            realtimeClock: new Date(),
            clockInterval: '',
            selectingUserInfo: false,
            selectedUserInfo: [],
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
                    }
                ],
                items: [],
                refreshInterval: '',
            },
            indexedHeaders: {
                Id: 'id',
                Fullname: 'fullname',
                Office: 'UserOffice',
                "Date Created": 'DateCreated'
            },
            // indexedHeaders: ["id", "fullname", "UserOffice", "DateCreated"]
        }
    },
    computed: {
        indexedItems () {
            return this.dataTable.items.map((item, index) => ({
                id: index + 1,
                fullname: item.USERFULLNAME,
                UserOffice: 'Philippine Overseas Employment Administration (POEA)',
                DateCreated: item.DATECREATED,
                ...item
            }))
        },
    },
    methods: {
        loadUserInfo(){
            this.loading = true;
            window.vue.prototype.$http.get('/api/userinfo')
            .then(response => {
                this.dataTable.items = response.data;
                // this.dataTable.items["DateCreated"] = response.data["DateCreated"]
                this.loading = false;
                // console.log(response.data);
            }).catch(error => {
                console.log(error);
            })
        },
        refreshUserInfo(){
            this.loading = true;
            window.vue.prototype.$http.get('/api/userinfo')
            .then(response => {
                this.dataTable.items = response.data;
                this.loading = false;
            }).catch(error => {
                console.log(error);
            })
        },
        handleRowClick(item, row){
            // console.log(row);
            if (row.isSelected === false){
                row.select(true);
                if (!this.selectedUserInfo.includes(item)) this.selectedUserInfo.push(item);
            }
            else {
                const index = this.selectedUserInfo.indexOf(item);
                this.selectedUserInfo.splice(index, 1);
                row.select(false);
            }                
            
            if (this.selectedUserInfo.length) this.selectingUserInfo = true
            else this.selectingUserInfo = false
        },
        handleDownloads(){
            jsontoexcel.getXlsx(this.indexedItems, this.indexedHeaders, 'test.xls');
        },
        handleClearSelection(){

            if (this.selectedUserInfo.length){
                this.selectedUserInfo = []; 
                this.selectingUserInfo = false;
            }
            this.$refs["dtUserInfo"].selection = 0;
            
        }

    },
    mounted(){
        this.loadUserInfo();
    },
    beforeDestroy(){
        console.log("Instance of Employees...Destroyed");
    }
}
</script>
<style>
    .theme--light.v-data-table tbody tr.v-data-table__selected {
        background: skyblue!important;
    }
</style>