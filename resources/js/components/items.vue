<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add new item</h5>
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
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="text" name="email" v-model="uPrice" placeholder="Price" /></td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="text" name="password" v-model="uDesc" placeholder="Description" /></td>
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
                    <div class="modal fade" id="removeEmployee" tabindex="-1" role="dialog" aria-labelledby="removeEmployeeLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="removeEmployeeLabel">Do you want to remove item <strong>{{this.uName}}</strong> ?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalClose" data-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-primary" v-on:click="removeEmployee">Yes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="updateEmployee" tabindex="-1" role="dialog" aria-labelledby="updateEmployeeLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateEmployeeLabel">Update item data.</h5>
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
                                                <td><input class="form-control" type="text" name="name"  v-model="uName" placeholder="Name"/></td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="text" name="price"  v-model="uPrice" placeholder="Price"/></td>
                                            </tr>
                                            <tr class="inputForm">
                                                <td><input class="form-control" type="test" name="desc" v-model="uDesc" placeholder="Description" /></td>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalClose" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" v-on:click="updateEmployee">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title" style="float:left">Item List</h4>
                            <button type="button" class="btn btn-danger" style="float:right" data-toggle="modal" data-target="#exampleModal">Add new item</button>
                            <!--                            <p class="card-category"> Here is a subtitle for this table</p>-->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <tr class="search-bar-1">
                                        <th><input class="form-control tableForm" type="text" name="name" v-model="name" placeholder="Name" /></th>
                                        <th><input class="form-control tableForm" type="text" name="price" v-model="price" placeholder="Price" /></th>
                                        <th><input class="form-control tableForm" type="text" name="desc" v-model="desc" placeholder="Description" /></th>
                                        <th><md-datepicker v-model="dateFrom">
                                            <label>Date From</label>
                                        </md-datepicker></th>
                                        <th><button class="btn btn-white btn-round btn-just-icon tableForm search" v-on:click="searchRecords"><i class="material-icons">search</i></button></th>
                                    </tr>
                                    <tr class="search-bar">
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
                                        <th>PRICE</th>
                                        <th>DESCRIPTION</th>
                                        <th>CREATED AT</th>
                                        <th>EDIT / DELETE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="record in records">
                                        <td>{{record.name}}</td>
                                        <td>{{record.price}}</td>
                                        <td>{{record.desc}}</td>
                                        <td>{{record.created_at}}</td>
                                        <td>
                                            <button type="button"  class="btn btn-success" data-toggle="modal" data-target="#updateEmployee"
                                                    v-on:click="removeUserSetValue(record.id, record.name, record.price, record.desc)">
                                                <i class="material-icons">edit</i>
                                            </button>
                                            <button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#removeEmployee"
                                                    v-on:click="removeUserSetValue(record.id, record.name, record.price, record.desc)">
                                                <i class="material-icons">close</i>
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
    .md-menu-content.md-select-menu {
        z-index: 9999 !important;
        width: 100%;
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

    .btn {
        padding: 10px 20px !important;
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
                price: '',
                desc: '',
                created_at: '',
                dateTo: '',
                dateFrom: '',
                search: {},
                uId: '',
                uName: '',
                uPrice: '',
                uDesc: ''


            }
        },
        methods: {
            updateEmployee() {
                var cookie = this.$cookie.get('token');
                var url = '/api/item/update';
                axios({
                    method: 'post',
                    url: url,
                    params: {
                        id: this.uId,
                        name: this.uName,
                        price: this.uPrice,
                        desc: this.uDesc
                    },
                    headers: {'auth': cookie}
                }).then( function (response) {
                    var session =  response.data.auth;
                    if(session == 'invalid') {
                        this.$cookie.delete('token');
                        this.$router.push({ name: 'login', query: { redirect: '/login' } });
                    } else {
                        this.uId = '';
                        this.uName = '';
                        this.uPrice = '';
                        this.uDesc = '';
                        $('.alert').removeClass("show");
                        $('.alert').addClass("fade");
                        $('.modalClose').click();
                        this.getRecords(this.page, 10);
                    }
                }.bind(this));
            },
            removeUserSetValue(id, name, price, desc) {
                this.uId = id;
                this.uName = name;
                this.uPrice = price;
                this.uDesc = desc;
            },
            removeEmployee() {
                var cookie = this.$cookie.get('token');
                var url = '/api/item/delete';
                axios({
                    method: 'post',
                    url: url,
                    params: {
                        id: this.uId
                    },
                    headers: {'auth': cookie}
                }).then( function (response) {
                    var session =  response.data.auth;
                    if(session == 'invalid') {
                        this.$cookie.delete('token');
                        this.$router.push({ name: 'login', query: { redirect: '/login' } });
                    } else {
                        this.uId = '';
                        this.uName = '';
                        this.uPrice = '';
                        this.uDesc = '';
                        $('.alert').removeClass("show");
                        $('.alert').addClass("fade");
                        $('.modalClose').click();
                        this.getRecords(this.page, 10);
                    }
                }.bind(this));
            },
            createRecord() {

                if (this.uName== '' && this.uPrice=='' && this.uDesc=='') {
                    $('.alert').removeClass("fade");
                    $('.alert').addClass("show");

                    return;
                }
                var cookie = this.$cookie.get('token');
                var url = '/api/item/create';
                axios({
                    method: 'post',
                    url: url,
                    params: {
                        name: this.uName,
                        price: this.uPrice,
                        desc: this.uDesc
                    },
                    headers: {'auth': cookie}
                }).then( function (response) {
                    var session =  response.data.auth;
                    if(session == 'invalid') {
                        this.$cookie.delete('token');
                        this.$router.push({ name: 'login', query: { redirect: '/login' } });
                    } else {
                        this.uId = '';
                        this.uName = '';
                        this.uPrice = '';
                        this.uDesc = '';
                        $('.alert').removeClass("show");
                        $('.alert').addClass("fade");
                        $('.modalClose').click();
                        this.getRecords(this.page, 10);
                    }
                }.bind(this));
            },
            searchRecords() {
                this.search['name'] = this.name;
                this.search['price'] = this.price;
                this.search['desc'] = this.desc;
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
                var url = '/api/item/get';
                axios({
                    method: 'get',
                    url: url,
                    params: {
                        page: page,
                        limit: limit,
                        search: this.search,
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

