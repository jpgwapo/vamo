<template>
    <div>
      <div class="wallet-box-scroll">
         <div class="wallet-bradcrumb">
            <h2><i class="fas fa-history"></i> Transaction</h2>
         </div>
         <div class="wallet-transaction clearfix">
        <div class="wallet-transaction-box clearfix" v-for="(item, index) in transactionList" :key="item.id">
                <div v-if="item.is_fraudulent" class="wallet-transaction-ico wallet-Withdrawal wallet-sync"><i class="fas fa-sync-alt"></i></div>
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
</template>

<script>
import * as moment from "moment";

export default {
    props: ['transactions', 'amount'],
    data() {
        return {
            transactionList: this.transactions,
            totalAmountList: this.amount,
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
