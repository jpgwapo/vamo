<template>
    <div>
        <div class="wallet-box-scroll">
            <div class="wallet-bradcrumb">
                <h2><i class="fas fa-user"></i> Profile</h2>
            </div>
            <div class="profile-page-area clearfix">
                <div class="profile-page-area-main">
                    <div class="profile-information-right">
                        <div class="profile-information-box">
                        <div class="theme-input-box">
                            <label>Name</label>
                            <input type="text" name="name" v-model="userList.name" class="theme-input">
                        </div>
                        <div class="theme-input-box">
                            <label>Email</label>
                            <input type="email" name="email" v-model="userList.email" class="theme-input">
                        </div>
                        <div class="profile-btn">
                            <button class="theme-btn">Save</button>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="profile-reset-password">
                    <div class="profile-information-box">
                        <h2 class="dashboard-title">Reset Password</h2>
                        <div class="theme-input-box">
                            <label>Old Password</label>
                            <input type="Password" name="" class="theme-input">
                        </div>
                        <div class="theme-input-box">
                            <label>New Password</label>
                            <input type="Password" name="" class="theme-input">
                        </div>
                        <div class="profile-btn">
                            <button class="theme-btn">Update</button>
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
    props: ['user'],
    data() {
        groupId: 1
        return {
            userList: this.user,
        }
    },
}
</script>
