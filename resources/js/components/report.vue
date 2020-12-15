<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Commission Report</h4>
                            <p class="card-category">Select a sales and time range to generate report</p>
                        </div>
                        <div class="card-body">
                            <div class="search-bar">
                                <div class="md-layout md-gutter">
                                    <div class="md-layout-item md-size-25">
                                        <md-field>
                                            <md-select v-model="sales_id">
                                                <md-option value="">Select a sales</md-option>
                                                <md-option
                                                    v-for="user in employee" v-bind:key="user.id"
                                                    :value="user.id">{{user.name}}</md-option>
                                            </md-select>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-size-25">
                                        <md-datepicker v-model="dateFrom">
                                            <label>Date From</label>
                                        </md-datepicker>
                                    </div>

                                    <div class="md-layout-item md-size-25">
                                        <md-datepicker v-model="dateTo">
                                            <label>Date To</label>
                                        </md-datepicker>
                                    </div>

                                    <div class="md-layout-item md-size-10">
                                        <button class="btn btn-white btn-round btn-just-icon tableForm search" v-on:click="searchRecords"><i class="material-icons">search</i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive printTable">
                                <table class="table commissionTable" id="printTable">
                                    <thead class=" text-primary">

                                    <tr>
                                        <th>ITEM</th>
                                        <th>W BONUS</th>
                                        <th>W/O BONUS</th>
                                        <th>ITEM COUNT</th>
                                        <th>ITEM TOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="record in records">
                                        <td>{{record.itemName}}</td>
                                        <td>{{record.withBonus}}</td>
                                        <td>{{record.withoutBonus}}</td>
                                        <td>{{record.numberItem}}</td>
                                        <td>${{record.itemTotal}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <th>Total Commission:</th>
                                        <td>${{this.total}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button"  class="btn btn-success print-button" style="float: right" v-on:click="print">
                                <i class="material-icons">print</i>
                            </button>
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
            this.getUsers();
            $('.commissionTable').hide();
            $('.print-button').hide();
        },
        data() {
            return {
                employee: [],
                records: [],
                sales: '',
                sales_id: '',
                dateTo: '',
                dateFrom: '',
                total: ''
            }
        },
        methods: {
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
            print() {

                // var doc = new jsPDF();
                // doc.fromHTML(`<html><head><title>${123}</title></head><body>` + document.getElementById('printTable').innerHTML + `</body></html>`);
                // doc.save('div.pdf');
                var HTML_Width = $(".printTable").width();
                var HTML_Height = $(".printTable").height();
                var top_left_margin = 15;
                var PDF_Width = HTML_Width+(top_left_margin*2);
                var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
                var canvas_image_width = HTML_Width;
                var canvas_image_height = HTML_Height;

                var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;


                html2canvas($(".printTable")[0],{allowTaint:true}).then(function(canvas) {
                    canvas.getContext('2d');

                    console.log(canvas.height+"  "+canvas.width);


                    var imgData = canvas.toDataURL("image/jpeg", 1.0);
                    var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
                    pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);


                    for (var i = 1; i <= totalPDFPages; i++) {
                        pdf.addPage(PDF_Width, PDF_Height);
                        pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
                    }

                    pdf.save("HTML-Document.pdf");
                });
            },
            searchRecords() {
                var cookie = this.$cookie.get('token');
                var url = '/api/user/report';
                axios({
                    method: 'post',
                    url: url,
                    params: {
                        sales_id: this.sales_id,
                        from: this.dateFrom,
                        to: this.dateTo,
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
                        this.records = response.data.records;
                        this.total = response.data.total;
                        $('.commissionTable').show();
                        $('.print-button').show();
                    }
                }.bind(this));

            }
        }
    }
</script>

