<template>
    <div>
         <div class="wallet-box-scroll">
            <div class="wallet-bradcrumb">
               <h2><i class="fas fa-coins"></i>Transfer money</h2>
            </div>
            <div class="tranfer-coin-box">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="transfer-coin-left-box">
                        <div class="transfer-coin-content">
                           <div class="transfer-coin-content-box active" id="sent-coin">
                              <div class="transfer-coin-input transfer-coin-select clearfix">
                                 <label>Select wallet</label>
                                 <select class="form-control" v-model="form.wallet_id">
                                    <option v-for="(name, key) in walletList" 
                                        :key="key" 
                                        v-bind:value="name.id">{{name.name}}
                                    </option>
                                 </select>
                              </div>
                              <div class="transfer-coin-input">
                                 <div class="transfer-coin-input">
                                    <label>Type</label>
                                       <select class="form-control" v-model="form.type">
                                          <option value="sent">Send</option>
                                          <option value="received">Receive</option>
                                       </select>
                                 </div>
                              </div>
                              <div class="transfer-coin-input">
                                 <div class="transfer-coin-input">
                                    <label>Description</label>
                                    <textarea class="form-control" placeholder="Task Description" rows="4" cols="50" v-model="form.description"></textarea>
                                 </div>
                              </div>
                              <div class="transfer-coin-input">
                                 <label>Amount</label>
                                 <div class="input-two clearfix">
                                    <div class="input-two-box">
                                       <input type="number" v-model="form.amount">
                                       <span>$</span>
                                    </div>
                                 </div>
                              </div>
                              <div class="transfer-coin-button">
                                 <button type="button" class="theme-btn" @click="save">Proceed</button>
                              </div>
                           </div>
                        </div>
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
    props: ['wallets', 'users', 'history'],
    data() {
        return {
            walletList: this.wallets,
            userList: this.users,
            historyList: this.history,
            
            form: {
               wallet_id : null,
               type : null,
               description : null,
               amount : null,
            },
        }
    },
    methods: {
         save() {
               const vm = this;
               axios.post('/transaction', this.form)
               .then(function (response) {
                  console.log(response);
                  vm.walletList.push(response.data.data);
                  vm.form.wallet_id = null
                  vm.form.type = null
                  vm.form.description = null
                  vm.form.amount = null
                  location.reload()
               })
               .catch(function (error) {
                  console.log(error)
               });
         },
         format_date(value){
            if (value) {
                  return moment(String(value)).format('DD MMM YYYY')
            }
         },
    }
}
</script>
