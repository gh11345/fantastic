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

                                                <td>
                                                    <md-field>
                                                        <md-select v-model="salesInput"  >
                                                            <md-option value="">Select a sales</md-option>
                                                            <md-option
                                                                v-for="user in employee" v-bind:key="user.id"
                                                                :value="user.id">{{user.name}}</md-option>
                                                        </md-select>
                                                    </md-field>
<!--                                                    <input class="form-control" type="text" name="sales" v-model="salesInput" placeholder="Sales" />-->
                                                </td>
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
                                                <td>
                                                    <md-field>
                                                        <md-select v-model="planInput"  >
                                                            <md-option value="">Select an plan</md-option>
                                                            <md-option
                                                                v-for="item in items" v-bind:key="item.id"
                                                                :value="item.id">{{item.name}}</md-option>
                                                        </md-select>
                                                    </md-field>
<!--                                                    <input class="form-control" v-model="planInput" name="plan" placeholder="PLAN">-->
                                                </td>
                                                <td>
                                                    <md-field>
                                                        <md-select v-model="ustatus"  >
                                                            <md-option value="">Select a status</md-option>
                                                            <md-option value="processed">processed</md-option>
                                                            <md-option value="canceled">canceled</md-option>
                                                        </md-select>
                                                    </md-field>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <md-datepicker v-model="ucreated_at">
                                                        <label>Application Date</label>
                                                    </md-datepicker>
                                                </td>
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
                    <div class="modal fade" id="updateRecord" tabindex="-1" role="dialog" aria-labelledby="updateRecordLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateRecordLabel">Update Sales Record</h5>
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
                                                <td><input class="form-control" type="text" name="name" v-model="uName" placeholder="Name" /></td>

                                                <td>
                                                    <md-field>
                                                        <md-select v-model="uSales"  >
                                                            <md-option value="">Select a sales</md-option>
                                                            <md-option
                                                                v-for="user in employee" v-bind:key="user.id"
                                                                :value="user.id">{{user.name}}</md-option>
                                                        </md-select>
                                                    </md-field>
                                                    <!--                                                    <input class="form-control" type="text" name="sales" v-model="salesInput" placeholder="Sales" />-->
                                                </td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="text" name="iccid" v-model="uIccid" placeholder="ICCID# (SIM#)" /></td>
                                                <td><input class="form-control" type="text" name="pos" v-model="uPos" placeholder="POS" /></td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="text" name="cm" v-model="uCm" placeholder="C/M #" /></td>
                                                <td><input class="form-control" type="text" name="port_in" v-model="uPort_in" placeholder="PORT IN #" /></td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="text" name="referer" v-model="uReferer" placeholder="REFERER" /></td>
                                                <td><input class="form-control" type="text" name="referer_number" v-model="uReferer_number" placeholder="R/F #" /></td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td>
                                                    <md-field>
                                                        <md-select v-model="uPlan"  >
                                                            <md-option value="">Select an plan</md-option>
                                                            <md-option
                                                                v-for="item in items" v-bind:key="item.id"
                                                                :value="item.id">{{item.name}}</md-option>
                                                        </md-select>
                                                    </md-field>
<!--                                                    <input class="form-control" v-model="uPlan" name="plan" placeholder="PLAN">-->
                                                </td>
                                                <td>
                                                    <md-field>
                                                        <md-select v-model="ustatus"  >
                                                            <md-option value="">Select a status</md-option>
                                                            <md-option value="processed">processed</md-option>
                                                            <md-option value="canceled">canceled</md-option>
                                                        </md-select>
                                                    </md-field>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="updateCreationTime">
                                                    <md-datepicker v-model="ucreated_at">
                                                        <label>Application Date</label>
                                                    </md-datepicker>
                                                </td>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalClose" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" v-on:click="updateRecord">Update</button>
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
                            <div class="search-bar">
                                <div class="md-layout md-gutter">
                                    <div class="md-layout-item md-size-15">
                                        <md-field>
                                            <md-input v-model="name" placeholder="Name"></md-input>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-field>
                                            <md-select v-model="sales">
                                                <md-option value="">Select a sales</md-option>
                                                <md-option
                                                    v-for="user in employee" v-bind:key="user.id"
                                                    :value="user.id">{{user.name}}</md-option>
                                            </md-select>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-field>
                                            <md-input v-model="iccid" placeholder="ICCID"></md-input>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-field>
                                            <md-input v-model="pos" placeholder="POS"></md-input>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-field>
                                            <md-input v-model="cm" placeholder="CM #"></md-input>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-field>
                                            <md-input v-model="port_in" placeholder="PORT IN #"></md-input>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-field>
                                            <md-input v-model="referer" placeholder="REFERER"></md-input>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-field>
                                            <md-input v-model="referer_number" placeholder="R/F #"></md-input>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-field>
                                            <md-select v-model="plan"  >
                                                <md-option value="">Select an plan</md-option>
                                                <md-option
                                                    v-for="item in items" v-bind:key="item.id"
                                                    :value="item.id">{{item.name}}</md-option>
                                            </md-select>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-datepicker v-model="dateFrom">
                                            <label>Date From</label>
                                        </md-datepicker>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-datepicker v-model="dateTo">
                                            <label>Date To</label>
                                        </md-datepicker>
                                    </div>

                                    <div class="md-layout-item md-size-15">
                                        <md-field>
                                            <md-select v-model="status"  >
                                                <md-option value="">Select a status</md-option>
                                                <md-option value="processed">processed</md-option>
                                                <md-option value="canceled">canceled</md-option>
                                            </md-select>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-10">
                                        <button class="btn btn-white btn-round btn-just-icon tableForm search" v-on:click="searchRecords"><i class="material-icons">search</i></button>
                                    </div>

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class=" text-primary">
                                        <tr style="font-size: 15px !important;">
                                            <th class="tableHeaderFont">NAME</th>
                                            <th class="tableHeaderFont">SALES</th>
                                            <th class="tableHeaderFont">ICCID# (SIM#)</th>
                                            <th class="tableHeaderFont">POS</th>
                                            <th class="tableHeaderFont">C/M #</th>
                                            <th class="tableHeaderFont">PORT IN #</th>
                                            <th class="tableHeaderFont">REFERER</th>
                                            <th class="tableHeaderFont">R/F #</th>
                                            <th class="tableHeaderFont">PLAN</th>
                                            <th class="tableHeaderFont">DATE</th>
                                            <th class="tableHeaderFont">STATUS</th>
                                            <th class="tableHeaderFont">EDIT</th>
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
                                            <td>
                                                <div v-if="record.status == 'processed'">
                                                    <i class="material-icons">check</i>
                                                </div>
                                                <div v-if="record.status == 'canceled'">
                                                    <i class="material-icons">close</i>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button"  class="btn btn-success" data-toggle="modal" data-target="#updateRecord"
                                                        v-on:click="updateSetValue(record.id, record.name, record.sales_id, record.iccid,
                                                        record.pos, record.cm, record.port_in, record.referer, record.referer_number,
                                                        record.plan_id, record.status, record.created_at)">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                            </td>
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

    .tableHeaderFont {
        font-size: 15px !important;
        font-weight: bold !important;
    }
    .dropdown-search {
        width: 60% !important;
    }
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

    .md-datepicker-dialog {
        z-index: 9999 !important;
    }
</style>
<script>
    export default {

        mounted() {
            this.getUsers();
            this.getItems();
            this.getRecords(1,10);
        },
        data() {
            return {
                records:[],
                employee:[],
                items:[],
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
                uId: '',
                uName: '',
                uSales: '',
                uIccid: '',
                uPos: '',
                uCm: '',
                uPort_in: '',
                uReferer: '',
                uReferer_number: '',
                uPlan: '',
                status: '',
                ustatus: '',
                ucreated_at: '',
                role: ''
            }
        },
        methods: {
            auth() {
                var cookie = this.$cookie.get('token');
                if(cookie=='' || cookie=='undefined' || cookie == null) {
                    this.$router.push({ name: 'login', query: { redirect: '/login' } });
                }
                else {
                    axios({
                        method: 'post',
                        url: '/api/user/authenticate',
                        headers: {'auth':cookie}

                    }).then( function (response) {
                        var session =  response.data.auth;
                        if(session!='valid') {
                            this.$cookie.delete('token');
                            this.$router.push({ name: 'login', query: { redirect: '/login' } });
                        } else {
                            this.role = response.data.role;
                            if (this.role !='admin') {
                                $('.updateCreationTime').remove();
                            }
                        }

                    }.bind(this));
                }
            },
            updateRecord() {
                var cookie = this.$cookie.get('token');
                var url = '/api/record/update';
                axios({
                    method: 'post',
                    url: url,
                    params: {
                        id: this.uId,
                        name: this.uName,
                        sales: this.uSales,
                        iccid: this.uIccid,
                        pos: this.uPos,
                        cm: this.uCm,
                        port_in: this.uPort_in,
                        referer: this.uReferer,
                        referer_number: this.uReferer_number,
                        plan: this.uPlan,
                        status: this.ustatus,
                        created_at : this.ucreated_at
                    },
                    headers: {'auth': cookie}
                }).then( function (response) {
                    var session =  response.data.auth;
                    if(session == 'invalid') {
                        this.$cookie.delete('token');
                        this.$router.push({ name: 'login', query: { redirect: '/login' } });
                    } else {
                        this.nameInput = '';
                        this.salesInput = '';
                        this.iccidInput = '';
                        this.posInput = '';
                        this.cmInput = '';
                        this.port_inInput = '';
                        this.refererInput = '';
                        this.referer_numberInput = '';
                        this.planInput = '';
                        this.ustatus = '';
                        this.ucreated_at = '';

                        $('.alert').removeClass("show");
                        $('.alert').addClass("fade");
                        $('.modalClose').click();
                        this.getRecords(this.page, 10);
                    }
                }.bind(this));
            },
            updateSetValue(id, name, sales, iccid, pos, cm, port_in, referer, referer_number, plan, status, created_at) {
                this.uId = id;
                this.uName = name;
                this.uSales = sales;
                this.uIccid = iccid;
                this.uPos = pos;
                this.uCm = cm;
                this.uPort_in = port_in;
                this.uReferer = referer;
                this.uReferer_number = referer_number;
                this.uPlan = plan;
                this.ustatus = status;
                this.ucreated_at = created_at;
            },
            getItems() {
                var cookie = this.$cookie.get('token');
                var url = '/api/item/get';
                axios({
                    method: 'get',
                    url: url,
                    params: {
                        page: 0,
                        limit: 0,
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
                        this.items = response.data.data;
                    }
                }.bind(this));
            },
            getUsers() {
                var cookie = this.$cookie.get('token');
                var url = '/api/user/get-users';
                axios({
                    method: 'get',
                    url: url,
                    params: {
                        page: 0,
                        limit: 0
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
                        this.employee = response.data.data;
                    }
                }.bind(this));
            },
            createRecord() {

                if (this.nameInput== '' && this.salesInput=='' && this.iccidInput=='' && this.posInput==''
                    && this.cmInput=='' && this.port_inInput=='' && this.refererInput=='' && this.referer_numberInput==''
                    && this.planInput=='' && this.ustatus=='' && this.ucreated_at=='') {
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
                        plan: this.planInput,
                        status: this.ustatus,
                        created_at : this.ucreated_at
                    },
                    headers: {'auth': cookie}
                }).then( function (response) {
                    var session =  response.data.auth;
                    if(session == 'invalid') {
                        this.$cookie.delete('token');
                        this.$router.push({ name: 'login', query: { redirect: '/login' } });
                    } else {
                        this.nameInput = '';
                        this.salesInput = '';
                        this.iccidInput = '';
                        this.posInput = '';
                        this.cmInput = '';
                        this.port_inInput = '';
                        this.refererInput = '';
                        this.referer_numberInput = '';
                        this.planInput = '';
                        this.ustatus = '';
                        this.ucreated_at = '';

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
                this.search['status'] = this.status;

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

