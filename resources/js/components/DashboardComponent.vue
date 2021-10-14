<template>
    <div>
         <div class="wallet-box-scroll">
            <div class="wallet-bradcrumb">
               <h2><i class="fas fa-tachometer-alt"></i>Dashboard</h2>
            </div>
            <div class="wallet-box-main clearfix">
               <div class="wallet-box-left">
                  <div class="wallet-balance">
                     <h2 class="dashboard-title">Outgoing Balance</h2>
                     <div class="wallet-transaction-box clearfix" v-for="(list, index) in totalSentList" :key="list.id">
                        <div class="wallet-transaction-ico">
                              <i class="fas fa-dollar-sign"></i>
                        </div>  
                        <div class="wallet-transaction-name">
                           <h3>{{ list.name }}</h3>
                           <span></span>
                        </div> 
                        <div class="wallet-transaction-balance">
                           <h3>$ {{ list.amount }}</h3>
                           <span></span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="wallet-box-left">
                  <div class="wallet-balance">
                     <h2 class="dashboard-title">Incoming Balance</h2>
                     <div class="wallet-transaction-box clearfix" v-for="(list, index) in totalReceivedList" :key="list.id">
                        <div class="wallet-transaction-ico">
                           <i class="fas fa-dollar-sign"></i>
                        </div>  
                        <div class="wallet-transaction-name">
                           <h3>{{ list.name }}</h3>
                           <span></span>
                        </div> 
                        <div class="wallet-transaction-balance">
                           <h3>$ {{ list.amount }}</h3>
                           <span></span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="wallet-box-right" style="width: 100%;">
                  <div class="wallet-transaction">
                     <h2 class="dashboard-title">Last Transaction</h2>
                     <div class="wallet-transaction-box clearfix" v-for="(item, index) in transactionList" :key="item.id">
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
               </div>
            </div>
         </div>
      </div>
</template>

<script>
import * as moment from "moment";

export default {
    props: ['received', 'sent', 'transactions'],
    data() {
        return {
            totalSentList: this.sent,
            totalReceivedList: this.received,
            transactionList: this.transactions,
        }
    },
    methods: {
        format_date(value){
            if (value) {
                return moment(String(value)).format('DD MMM YYYY')
            }
        },
        sum(value){
            let sum = 0;
            for (let i = 0; i < value.length; i++) {
                sum += value[i].amount;
            }
            return sum;
        },
    }
}
</script>
