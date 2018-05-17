<template>
    <div class="container">
        <div class="searchContainer">
            <h1>Find user on GitHub</h1>
            <input v-model="searchName" @keyup.enter="fetchUser" type="text" id="searchUser" class="form-control"
                   placeholder="GitHub Username...">
        </div>
        <br>
        <div id="profile" v-if="isUser && isLoaded">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{user.name}}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img class="thumbnail avatar" style="width: 100%;"
                                 :src="user.avatar_url">
                            <a target="_blank" class="btn btn-primary btn-block" :href="user.html_url">View on GitHub</a>
                        </div>
                        <div class="col-md-9">
                            <span class="label label-success"><strong>Followers: </strong> {{user.followers}}</span>
                            <span class="label label-danger"><strong>Following: </strong> {{user.following}}</span>
                            <span class="label label-info"><strong>Repositories: </strong> {{user.public_repos}}</span>
                            <br><br>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Company: </strong> {{user.company}}</li>
                                <li class="list-group-item"><strong>Location: </strong> {{user.location}}</li>
                                <li class="list-group-item"><strong>Member Since: </strong> {{(user.created_at).split('T')[0]}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="page-header"><strong>Followers: </strong></h3>
            <div id="follower" v-for="follower in followerList">
                <div class="well">
                    <div class="row" @click="searchName = follower.login; fetchUser()" style="cursor: pointer">
                        <div class="col-md-2">
                            <img :src="follower.avatar_url" alt="" width="70%">
                        </div>
                        <div class="col-md-5">
                            <strong>{{follower.login}}</strong>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-2">
                            <a :href="follower.html_url" target="_blank" class="btn btn-default">View on GitHub</a>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row" v-if="isFollowersLeft">
            <div class="col-md-5"></div>
            <div class="col-md-5"></div>
            <div class="col-md-2"><button class="btn btn-info" @click="fetchUserFollowers">More</button></div>
        </div>
        </div>
        <div class="app" v-if="!isLoaded">
            <svg class="loading-spinner" viewBox="-24 -24 48 48">
                <circle class="path" cx="0" cy="0" r="20" fill="none" stroke-width="4"></circle>
            </svg>
        </div>
    </div>
</template>
<script>
    export default {
        props: [],
        data() {
            return {
                isUser: false, // Did the user send a request
                searchName: '', // Search query
                user: {}, // The answer of yhe GitHub {user}
                followerList: [], // The answer of yhe GitHub {user's followers}
                isLoaded: true, // Was the request loaded
                currentFollowerPage: 1, // Current page for followers query
                remainingFollowers: 0, // Quantity of the remaining followers for the user
                isFollowersLeft: true, // Did the any followers left
                countPerPage: 10, // Number of the followers per page
            }
        },
        methods: {
            /* Function that requests the user by name from GitHub */
            fetchUser(){
                if(this.searchName.length >= 1){
                    this.isLoaded = false;
                    axios.get('https://api.github.com/users/' + this.searchName).then(response => {
                        this.user = response.data;
                        this.isUser = true;
                        this.isLoaded = true;
                        this.remainingFollowers = this.user.followers;
                        this.currentFollowerPage = 1;
                        this.isFollowersLeft = true;
                        this.fetchUserFollowers();
                    }).catch(e => {
                        console.log(e);
                        this.isLoaded = true;
                        this.$swal(
                            'Nothing matching.'
                        );
                    });
                }
                else {
                    this.$swal(
                        'Wrong action',
                        'User name can not be empty!',
                        'error'
                    );
                }
            },
            /* Function that requests the user followers from GitHub */
            fetchUserFollowers(){
                if (this.isFollowersLeft) {
                    axios.get(this.user.followers_url + '?per_page=' + this.countPerPage + '&page=' + this.currentFollowerPage).then(response => {
                        this.followerList = this.followerList.concat(response.data);
                        this.remainingFollowers -= this.countPerPage;
                        this.currentFollowerPage ++;
                        if (this.remainingFollowers <= 0) this.isFollowersLeft = false;
                    }).catch(e => {
                        console.log(e);
                        this.$swal(
                            'Error',
                            'Failed to load followers.',
                            'error'
                        );
                    });
                }
            },
        },
    };
</script>