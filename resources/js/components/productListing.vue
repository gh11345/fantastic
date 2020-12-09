<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Import Sales Record</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-warning fade" role="alert">Cannot submit empty form.</div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="text" name="name" v-model="nameInput" placeholder="Name" /></td>

                                                <td><input class="form-control" type="text" name="sales" v-model="salesInput" placeholder="Sales" /></td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="text" name="iccid" v-model="iccidInput" placeholder="ICCID# (SIM#)" /></td>
                                                <td><input class="form-control" type="text" name="pos" v-model="posInput" placeholder="POS" /></td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="text" name="cm" v-model="cmInput" placeholder="C/M #" /></td>
                                                <td><input class="form-control" type="text" name="port_in" v-model="port_inInput" placeholder="PORT IN #" /></td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="text" name="referer" v-model="refererInput" placeholder="REFERER" /></td>
                                                <td><input class="form-control" type="text" name="referer_number" v-model="referer_numberInput" placeholder="R/F #" /></td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" v-model="planInput" name="plan" placeholder="PLAN"></td>
<!--                                                <td><select class="form-control selectpicker" v-model="planInput" data-style="btn btn-link" id="exampleFormControlSelect1" placeholder="Select a Plan">-->
<!--                                                    <option>25</option>-->
<!--                                                    <option>41</option>-->
<!--                                                    <option>50</option>-->
<!--                                                    <option>65</option>-->
<!--                                                </select></td>-->
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalClose" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" v-on:click="createRecord">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title" style="float:left">Sales Records</h4>
                            <button type="button" class="btn btn-danger" style="float:right" data-toggle="modal" data-target="#exampleModal">Add Record</button>
<!--                            <p class="card-category"> Here is a subtitle for this table</p>-->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <tr class="search-bar-1">
                                            <th><input class="form-control tableForm" type="text" name="name" v-model="name" placeholder="Name" /></th>

                                            <th><input class="form-control tableForm" type="text" name="sales" v-model="sales" placeholder="Sales" /></th>

                                            <th><input class="form-control tableForm" type="text" name="iccid" v-model="iccid" placeholder="ICCID# (SIM#)" /></th>

                                            <th><input class="form-control tableForm" type="text" name="pos" v-model="pos" placeholder="POS" /></th>

                                            <th><input class="form-control tableForm" type="text" name="cm" v-model="cm" placeholder="C/M #" /></th>

                                            <th><input class="form-control tableForm" type="text" name="port_in" v-model="port_in" placeholder="PORT IN #" /></th>

                                            <th><input class="form-control tableForm" type="text" name="referer" v-model="referer" placeholder="REFERER" /></th>

                                            <th><input class="form-control tableForm" type="text" name="referer_number" v-model="referer_number" placeholder="R/F #" /></th>

                                            <th><input class="form-control tableForm" v-model="plan" name="plan" placeholder="PLAN"></th>
                                            <th><md-datepicker v-model="dateFrom">
                                                <label>Date From</label>
                                            </md-datepicker></th>

                                            <th><button class="btn btn-white btn-round btn-just-icon tableForm search" v-on:click="searchRecords"><i class="material-icons">search</i></button></th>
                                        </tr>
                                        <tr class="search-bar">
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><md-datepicker v-model="dateTo">
                                                <label>Date To</label>
                                            </md-datepicker></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>NAME</th>
                                            <th>SALES</th>
                                            <th>ICCID# (SIM#)</th>
                                            <th>POS</th>
                                            <th>C/M #</th>
                                            <th>PORT IN #</th>
                                            <th>REFERER</th>
                                            <th>R/F #</th>
                                            <th>PLAN</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="record in records">
                                            <td>{{record.name}}</td>
                                            <td>{{record.sales}}</td>
                                            <td>{{record.iccid}}</td>
                                            <td>{{record.pos}}</td>
                                            <td>{{record.cm}}</td>
                                            <td>{{record.port_in}}</td>
                                            <td>{{record.referer}}</td>
                                            <td>{{record.referer_number}}</td>
                                            <td>{{record.plan}}</td>
                                            <td>{{record.created_at}}</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <nav aria-label="Page navigation example">
                                    <ul class="pagination" v-if="pageNum > 1">
                                        <div v-if="page > 1">
                                            <li class="page-item" @click="switchPage(page-1)"><a class="page-link">Previous</a></li>
                                        </div>

                                        <div v-if="(page-2) >=1" >
                                            <li class="page-item" @click="switchPage(page-2)"><a class="page-link ">{{page-2}}</a></li>
                                        </div>

                                        <div v-if="(page-1) >=1" >
                                            <li class="page-item" @click="switchPage(page-1)"><a class="page-link ">{{page-1}}</a></li>
                                        </div>


                                        <li class="page-item" @click="switchPage(page)"><a class="page-link activePage">{{page}}</a></li>


                                        <div v-if="(page+1) <= pageNum" >
                                            <li class="page-item" @click="switchPage(page+1)"><a class="page-link ">{{page+1}}</a></li>
                                        </div>

                                        <div v-if="(page+2) <= pageNum" >
                                            <li class="page-item" @click="switchPage(page+2)"><a class="page-link ">{{page+2}}</a></li>
                                        </div>

<!--                                        <div v-for="index in pageNum">-->
<!--                                            <div v-if="page == index">-->
<!--                                                <li class="page-item" @click="switchPage(index)"><a class="page-link activePage">{{index}}</a></li>-->
<!--                                            </div>-->
<!--                                            <div v-if="page != index">-->
<!--                                                <li class="page-item" @click="switchPage(index)"><a class="page-link" >{{index}}</a></li>-->
<!--                                            </div>-->

<!--                                        </div>-->

                                        <div v-if="(page+1) <= pageNum">
                                            <li class="page-item" @click="switchPage(page+1)"><a class="page-link">Next</a></li>
                                        </div>
                                    </ul>

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .tableForm {
        #margin-bottom: 30px;
    }

    .inputForm {
        border-bottom: 2px solid #ffffff!important;
        border-top: 2px solid #ffffff!important;
    }

    .search-bar-1 {
        border-bottom: 2px solid #ffffff!important;
    }
    .search-bar {
        border-bottom: 2px solid #b54e4e!important;
    }

    .activePage {
        background-color: #9c27b0;
        border-color: #9c27b0;
        color: #fff !important;
        box-shadow: 0 4px 5px 0 rgba(156,39,176,.14), 0 1px 10px 0 rgba(156,39,176,.12), 0 2px 4px -1px rgba(156,39,176,.2);
        border: 0;
        border-radius: 30px!important;
        transition: all .3s;
        padding: 0 11px;
        margin: 0 3px;
        min-width: 30px;
        height: 30px;
        line-height: 30px;
        color: #999;
        font-weight: 900;
        font-size: 12px;
        text-transform: uppercase;
        text-align: center;
    }
</style>
<script>
    export default {

        mounted() {
            this.getRecords(1,10);
        },
        data() {
            return {
                records:[],
                recordCount: 0,
                total: 0,
                page: 1,
                pageNum: 0,
                accessLevel: '',
                keyword : '',
                name: '',
                sales: '',
                iccid: '',
                pos: '',
                cm: '',
                port_in: '',
                referer: '',
                referer_number: '',
                plan: '',
                dateTo: '',
                dateFrom: '',
                search: {},
                nameInput: '',
                salesInput: '',
                iccidInput: '',
                posInput: '',
                cmInput: '',
                port_inInput: '',
                refererInput: '',
                referer_numberInput: '',
                planInput: '',
            }
        },
        methods: {
            createRecord() {

                if (this.nameInput== '' && this.salesInput=='' && this.iccidInput=='' && this.posInput==''
                    && this.cmInput=='' && this.port_inInput=='' && this.refererInput=='' && this.referer_numberInput==''
                    && this.planInput=='') {
                    $('.alert').removeClass("fade");
                    $('.alert').addClass("show");

                    return;
                }


                var cookie = this.$cookie.get('token');
                var url = '/api/record/create';
                axios({
                    method: 'post',
                    url: url,
                    params: {
                        name: this.nameInput,
                        sales: this.salesInput,
                        iccid: this.iccidInput,
                        pos: this.posInput,
                        cm: this.cmInput,
                        port_in: this.port_inInput,
                        referer: this.refererInput,
                        referer_number: this.referer_numberInput,
                        plan: this.planInput
                    },
                    headers: {'auth': cookie}
                }).then( function (response) {
                    var session =  response.data.auth;
                    if(session == 'invalid') {
                        this.$cookie.delete('token');
                        this.$router.push({ name: 'login', query: { redirect: '/login' } });
                    } else {
                        $('.alert').removeClass("show");
                        $('.alert').addClass("fade");
                        $('.modalClose').click();
                        this.getRecords(this.page, 10);
                    }
                }.bind(this));
            },
            searchRecords() {
                this.search['name'] = this.name;
                this.search['sales'] = this.sales;
                this.search['iccid'] = this.iccid;
                this.search['pos'] = this.pos;
                this.search['cm'] = this.cm;
                this.search['port_in'] = this.port_in;
                this.search['referer'] = this.referer;
                this.search['referer_number'] = this.referer_number;
                this.search['plan'] = this.plan;
                this.search['dateFrom'] = this.dateFrom;
                this.search['dateTo'] = this.dateTo;

                this.getRecords(1,10)
            },
            switchPage(index) {
                this.page = index;
                this.getRecords(index, 10);
            },

            getRecords(page,limit) {
                var cookie = this.$cookie.get('token');
                var url = '/api/record/get';
                axios({
                    method: 'get',
                    url: url,
                    params: {
                        page: page,
                        limit: limit,
                        search: this.search,
                        // filter: this.filterCollection,
                        // sort: this.sortCollection
                    },
                    headers: {'auth': cookie}
                }).then( function (response) {
                    var session =  response.data.auth;
                    if(session == 'invalid') {
                        this.$cookie.delete('token');
                        this.$router.push({ name: 'login', query: { redirect: '/login' } });
                    } else {
                        if (typeof response.data.fail !== 'undefined') {
                            alert(response.data.fail);
                            return;
                        }
                        this.recordCount = (response.data.data).length;
                        this.records = response.data.data;
                        this.total = response.data.count;
                        this.page = page;
                        this.pageNum = Math.ceil(this.total/response.data.limit);
                    }
                }.bind(this));
            }
        }
    }
</script>

