<template>
    <div>
      <div class="wallet-box-scroll">
        <div class="wallet-bradcrumb">
            <button type="button" class="btn btn-primary" @click="addWalletModal()" data-dismiss="modal">Add wallet</button>
            <h2><i class="fas fa-wallet"></i>My Wallet</h2>
        </div>
        <div class="wallet-balance-area clearfix">
            <div class="wallet-balance-box wallet1" @click="edit(list)" v-for="(list, index) in totalWalletList" :key="'A'+ index" >
               <h3>{{ list.name }} Wallet</h3>
               <h6>{{ format_date(list.created_at) }} </h6>
            </div>
         </div>
         <div class="wallet-transaction clearfix">
            <h2 class="dashboard-title">Last Transaction</h2>
            <div class="wallet-transaction-box clearfix" style="cursor: pointer;" @click="editTransact(item)" v-for="(item, index) in transactionList" :key="'B'+ index">
                <div v-if="item.is_fraudulent" class="wallet-transaction-ico wallet-sync"><i class="fas fa-sync-alt"></i></div>
                <div v-else-if="item.type == 'sent'" class="wallet-transaction-ico wallet-Withdrawal"><i class="fas fa-arrow-up"></i></div>
                <div v-else class="wallet-transaction-ico"><i class="fas fa-arrow-down"></i></div>
                <div class="wallet-transaction-name">
                    <h3 v-if="item.is_fraudulent" style="text-decoration-line: line-through">{{ item.type }}</h3>
                    <h3 v-else>{{ item.type }}</h3>
                    <span>{{ item.description }}</span>
                </div>
                <div class="wallet-transaction-balance">
                    <h3 v-if="item.is_fraudulent" style="text-decoration-line: line-through">{{ item.amount }}</h3>
                    <h3 v-else>{{ item.amount }}</h3>
                    <span>{{ format_date(item.created_at) }}</span>
                </div>
            </div>
         </div>
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Rename/Delete wallet</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Wallet Name</label>
                                <input type="text" class="form-control" v-model="formEdit.name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="rename(formEdit)">Save changes</button>
                            <button type="button" class="btn btn-danger" @click="remove(formEdit)">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addNewWalletModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add wallet</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" v-model="formAddWallet.walletName" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" @click="saveNewWallete(formAddWallet)">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editTransactModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Mark as Fraudulent/Delete the trasaction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="fname">Type:</label>
                                <p style="color: cornflowerblue;"> {{formTransactEdit.type }} </p>
                                <label for="lname">Descripion:</label>
                                <p style="color: cornflowerblue;"> {{formTransactEdit.description }} </p>
                                <label for="lname">Amount:</label>
                                <p style="color: cornflowerblue;"> {{formTransactEdit.amount }} </p>
                                <label for="lname">Date:</label>
                                <p style="color: cornflowerblue;"> {{formTransactEdit.created_at }} </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="formTransactEdit.is_fraudulent" disabled type="button"  class="btn btn-warning" @click="addFrudTransact(formTransactEdit)">Fraudulent</button>
                            <button v-else type="button"  class="btn btn-warning" @click="addFrudTransact(formTransactEdit)">Fraudulent</button>
                            <button type="button" class="btn btn-danger" @click="deleteTransact(formTransactEdit)">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
</template>

<script>
import * as moment from "moment";

export default {
    props: ['transactions', 'amount', 'wallet'],
    data() {
        return {
            transactionList: this.transactions,
            totalAmountList: this.amount,
            totalWalletList: this.wallet,
            formEdit: {
                name: null,
                wallet_id: null,
            },
            formTransactEdit: {
                type: null,
                description: null,
                amount: null,
                id: null,
                is_fraudulent: null,
            },
            formAddWallet: {
                walletName: null,
                user_id: null,
            },
        }
    },
    methods: {
        format_date(value){
            if (value) {
                return moment(String(value)).format('DD MMM YYYY')
            }
        },
        edit(item) {
            console.log(item)
            this.formEdit.name = item.name;
            this.formEdit.wallet_id = item.wallet_id;
            $('#editModal').modal('show');
        },
        rename(item) {
            console.log(item)
            const vm = this;
            axios.put(`/transfer/${item.wallet_id}`, item)
            .then(function (response) {
                console.log(response)
                $('#editModal').modal('hide');
                setTimeout(function(){
                    window.location.reload(1);
                }, 1500);
            })
            .catch(function (error) {
                console.log(error)
            });
        },
        saveNewWallete(item) {
            console.log(item)
            const vm = this;
            axios.post('/transfer', this.formAddWallet)
            .then(function (response) {
                console.log(response)
                vm.formAddWallet.walletName = null
                location.reload()
                // setTimeout(function(){
                //     window.location.reload(1);
                // }, 1500);
            })
            .catch(function (error) {
                console.log(error)
            });
        },
        remove(item) {
            console.log(item)
            const vm = this;
            axios.delete(`/transfer/softDelete/${item.wallet_id}`)
            .then(function (response) {
                console.log(response)
                // location.reload();
            })
            .catch(function (error) {
                console.log(error)
            });
        },
        editTransact(item) {
            console.log(item)
            this.formTransactEdit.type = item.type
            this.formTransactEdit.description = item.description
            this.formTransactEdit.amount = item.amount
            this.formTransactEdit.created_at = this.format_date(item.created_at)
            this.formTransactEdit.id = item.id
            this.formTransactEdit.is_fraudulent = item.is_fraudulent
            $('#editTransactModal').modal('show');
        },
        addWalletModal() {
            $('#addNewWalletModal').modal('show');
        },
        addFrudTransact(item) {
            console.log(item)
            const vm = this;
            axios.put(`/transaction/${item.id}`, item)
            .then(function (response) {
                console.log(response)
                $('#editTransactModal').modal('hide');
                location.reload();
            })
            .catch(function (error) {
                console.log(error)
            });
        },
        deleteTransact(item) {
            const vm = this;
            axios.delete(`/transaction/softDelete/${item.id}`)
            .then(function (response) {
                console.log(response)
                location.reload();
            })
            .catch(function (error) {
                console.log(error)
            });
        },
    },

}
</script>
