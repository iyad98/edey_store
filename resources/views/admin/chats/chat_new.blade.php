@extends('admin.layout')


@push('css')

    <!-- Slicknav -->
    <link rel="stylesheet" type="text/css" href="{{url('')}}/admin_assets/assets/general/css/chat/slicknav.css">

    <!-- Nivo Lightbox -->
    <link rel="stylesheet" type="text/css" href="{{url('')}}/admin_assets/assets/general/css/chat/nivo-lightbox.css">
    <!-- Text Editor -->
    <link rel="stylesheet" type="text/css" href="{{url('')}}/admin_assets/assets/general/css/chat/summernote.css">
    <!-- Animate -->
    <link rel="stylesheet" type="text/css" href="{{url('')}}/admin_assets/assets/general/css/chat/animate.css">
    <!-- Owl carousel -->
    <link rel="stylesheet" type="text/css" href="{{url('')}}/admin_assets/assets/general/css/chat/owl.carousel.css">
    <!-- Main Style -->
    <link rel="stylesheet" type="text/css" href="{{url('')}}/admin_assets/assets/general/css/chat/main.css">
    <!-- Responsive Style -->
    <link rel="stylesheet" type="text/css" href="{{url('')}}/admin_assets/assets/general/css/chat/responsive.css">

    <style>
        .vertical-scroll {
            height: 705px;
            overflow: hidden;
            overflow-y: scroll;

        }

        .chat-time {
            display: block;
            font-size: 12px;
            color: unset;
        }

        .blockUI .m-loader {
            margin-top: -270px !important;
        }
    </style>

@endpush


@section('content')


    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">{{trans('admin.orders')}}</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('admin.index')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>

                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('admin.orders.index')}}" class="m-nav__link">

                            <span class="m-nav__link-text">{{trans('admin.orders')}}</span>
                        </a>
                    </li>

                </ul>
            </div>
            <div>
                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                     m-dropdown-toggle="hover" aria-expanded="true">
                    <a href="#"
                       class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                        <i class="la la-plus m--hide"></i>
                        <i class="la la-ellipsis-h"></i>
                    </a>
                    <div class="m-dropdown__wrapper">
                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner">
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav">
                                        <li class="m-nav__section m-nav__section--first m--hide">
                                            <span class="m-nav__section-text">Quick Actions</span>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                <span class="m-nav__link-text">Activity</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                <span class="m-nav__link-text">Messages</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                <span class="m-nav__link-text">FAQ</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                <span class="m-nav__link-text">Support</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__separator m-nav__separator--fit">
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="#"
                                               class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="content" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h4 class="widget-title">{{trans('admin.all_messages')}} </h4>
                    <div class="row ">
                        <div class="col-sm-5 mt-2">
                            <input @keyup.enter="get_orders(1)" v-model="search" type="text" class="form-control"
                                   placeholder="{{trans('admin.search_order_number')}}">
                        </div>
                    </div>

                    <br>
                    <div class="wrapper">
                        <div class="container-m">
                            <div class="left vertical-scroll">
                                <ul class="people">
                                    <li v-for="order_ in orders" @click="set_order(order_.id)" class="person"
                                        :data-chat="'person'+order_.id">
                                        <span class="preview">{{trans('admin.order_number')}} : @{{ order_.id }}</span>
                                        <img
                                                alt=""/>
                                        <span class="name"
                                              v-text="order_.user_name"></span>
                                        <span class="time" v-text=""></span>

                                    </li>

                                    <button :disabled="order_loading" @click="get_next_orders()" type="button"
                                            class="btn btn-primary btn-block"
                                            :class="order_loading ? 'm-loader m-loader--light m-loader--left' : ''"
                                            style="margin-top: 30px;"
                                    > {{trans('admin.show_more')}}</button>
                                    <li class="person" data-chat="person2" style="visibility: hidden;">
                                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/382994/dog.png" alt=""/>
                                        <span class="name">???????? ????????????</span>
                                        <span class="time">1:44 PM</span>
                                        <span class="preview">?????? ?????????? ???????????? ?????????????? ?????????????? ???????? ???????????? ...</span>
                                    </li>

                                </ul>


                            </div>
                            <div class="right">
                                <div class="top"><span>{{trans('admin.chat_with')}} : <span class="name"
                                                                                            v-text="getChatName"></span></span>
                                </div>
                                <div class="chat" data-chat="person">
                                    {{--
                                    <div class="conversation-start">
                                        <span>Today, 5:38 PM</span>
                                    </div>
                                    --}}
                                    <div id="scrollChat" style=" overflow-y: scroll;overflow-x: hidden">
                                        <div v-for="chat in chats">
                                            <div class="bubble"
                                                 :class="chat.data.sender_id == order.user_id ? 'you' : 'me'">
                                                <span v-if="chat.data.message_type == 'text'"
                                                      v-text="chat.data.msg"></span>

                                                <span v-else-if="chat.data.message_type == 'image'">
                                                    <a target="_blank" :href="chat.data.media_url">
                                                        <img :src="chat.data.media_url" width="80" height="80">
                                                    </a>
                                                </span>

                                                <span class="chat-time">@{{ chat.data.time ? timeConverter(chat.data.time.seconds) : '' }}</span>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="write">
                                    <div class="row" style="margin-top: -12px;">
                                        <div class="col-sm-9">
                                            <input type="text" v-model="message" class="form-control"
                                                   @keyup.enter="send_message">
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="javascript:;" @click="send_message"
                                               class="btn btn-secondary m-btn m-btn--icon">
															<span>
																<i class="flaticon-paper-plane"></i>
																<span>{{trans('admin.send')}}</span>
															</span>
                                            </a>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





@push('js')

    <script>
                {{-- var collections_doc = {!! $order_pending !!}; --}}

       // var audio = new Audio('https://159.65.221.138/bell.mp3');
    </script>
    <script src="https://www.gstatic.com/firebasejs/6.3.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.3.0/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.3.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.3.0/firebase-database.js"></script>

    <script>

        function dynamicSort(property) {
            var sortOrder = 1;
            if (property[0] === "-") {
                sortOrder = -1;
                property = property.substr(1);
            }
            return function (a, b) {
                /* next line works with strings and numbers,
                 * and you may want to customize it to your needs
                 */
                var result = (a[property] > b[property]) ? -1 : (a[property] < b[property]) ? 1 : 0;
                return result * sortOrder;
            }
        }

        function get_data_once(user_id, order_id) {
            db.collection(user_id + "/" + order_id + "/messages/").orderBy('time')
                .get()
                .then(function (querySnapshot) {
                    querySnapshot.forEach(function (doc) {
                        vm.chats.push({id: doc.id, data: doc.data()});

                    });

                    mApp.unblock(".chat", {});
                    vm.$nextTick(function () {
                        $("#scrollChat").animate({scrollTop: $('#scrollChat').prop("scrollHeight")}, 1000);
                    });


                })
                .catch(function (error) {
                    console.log("Error getting documents: ", error);
                });
            //  listen_to_change(user_id, order_id);
        }

        function send_message_to_firestore(order_id, message) {

            db.collection("orders").doc(order_id).set({
                time : firebase.firestore.FieldValue.serverTimestamp()
            });
            db.collection("orders/" + order_id + "/messages/").add({
                media_url: "",
                message_type: "text",
                msg: message,
                sender_id: "0",
                time: firebase.firestore.FieldValue.serverTimestamp()
            }).then(function (docRef) {
                //  console.log("Document written with ID: ", docRef.id);
            }).catch(function (error) {
                // console.error("Error adding document: ", error);
            });
        }

        function listen_to_change(order_id) {
            vm.chats = [];
            mApp.block(".chat", {});
            db.collection("orders/" + order_id + "/messages/").orderBy('time').onSnapshot(function (snapshot) {
                snapshot.docChanges().forEach(function (change) {
                    if (change.type === "added") {
                        if (vm.can_play_audio == 1 && change.doc.data().sender_id != 0) {
                            //  audio.play();
                        }
                        vm.chats.push({id: change.doc.id, data: change.doc.data()});
                    }
                    if (change.type === "modified") {
                        if (vm.can_play_audio == 1 && change.doc.data().sender_id != 0) {
                            // audio.play();
                        }
                        vm.update_doc(change.doc.id, change.doc.data());
                    }
                    if (change.type === "removed") {
                        //console.log(change.doc.id + " " + change.doc.data().message);
                    }
                });

                vm.can_play_audio = 1;
                mApp.unblock(".chat", {});
                vm.$nextTick(function () {
                    $("#scrollChat").animate({scrollTop: $('#scrollChat').prop("scrollHeight")}, 1000);
                });

            });


        }

        function get_paginate_orders(first) {

            /*  var first = db.collection("orders")
                  .orderBy("time" ,'desc')
                  .limit(2);*/
            if (first != undefined) {
                first.onSnapshot(function (documentSnapshots) {
                    vm.order_loading = false;

                    documentSnapshots.docChanges().forEach(function (change) {

                        var order = {
                            id: change.doc.id,
                            user_id: change.doc.data().user_id,
                            user_name: change.doc.data().user_name,
                            time: change.doc.data().time ? change.doc.data().time.seconds : '',
                        };

                        if (change.type === "modified") {
                            vm.orders.unshift(order);

                        } else if (change.type === "removed") {

                        } else {
                            vm.orders.push(order);
                        }
                        vm.orders.sort(dynamicSort("time"));
                        vm.remove_duplicate();
                    });

                    var lastVisible = documentSnapshots.docs[documentSnapshots.docs.length - 1];


                    if (lastVisible != undefined) {
                        var next = db.collection("orders")
                            .orderBy("time", 'desc')
                            .startAfter(lastVisible)
                            .limit(1);

                        vm.next_order = next;
                    } else {
                        //alert('stop');
                    }


                });
            }

        }


        firebase.initializeApp({
            apiKey: 'AIzaSyBeUfNpOFN9ZyUvpZqzGBhzRjTnZY6A_DA',
            authDomain: 'saidalista-ff519.firebaseapp.com',
            databaseURL: "https://saidalista-ff519.firebaseio.com",
            projectId: 'saidalista-ff519'
        });

        var db = firebase.firestore();
        var first = db.collection("orders")
            .orderBy("time", 'desc')
            .limit(2);


    </script>

    <script>

        var vm = new Vue({
            el: '#content',
            created: function () {
                this.get_orders(0);
            },
            data: {
                chats: [],
                orders: [],
                order: '',
                order_id : '',
                message: '',
                search: '',
                getChatName: '',

                order_loading: false,
                page: 1,

                can_play_audio: 0,

                init_state: 1,
                next_order: '',
            },
            methods: {
                send_message: function () {

                    var message = this.message;
                    var order_id = this.order_id;
                    if (message != '') {
                        send_message_to_firestore(order_id, message);
                        this.message = "";
                    }
                },
                set_order: function (order_id) {
                    this.order_id = order_id;
                    listen_to_change(order_id);
                },

                update_doc: function (doc_id, data) {

                    var get_index = -1;
                    this.chats.forEach(function (value, index) {
                        if (value.id == doc_id) {
                            get_index = index;
                        }

                    });
                    Vue.set(this.chats, get_index, {id: doc_id, data: data});
                },
                timeConverter: function (UNIX_timestamp) {
                    var time = "";
                    if (UNIX_timestamp != 'null') {
                        var a = new Date(UNIX_timestamp * 1000);
                        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        var year = a.getFullYear();
                        var month = months[a.getMonth()];
                        var date = a.getDate();
                        var hour = a.getHours();
                        var min = a.getMinutes();
                        var sec = a.getSeconds();
                        time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec;
                    }

                    return time;
                },

                get_orders: function (is_search) {
                    this.order_loading = true;
                    get_paginate_orders(first);

                },
                get_next_orders: function () {
                    if (this.next_order == '') {
                        get_paginate_orders(first);
                    } else {
                        get_paginate_orders(this.next_order);
                    }
                },
                next_page: function () {
                    this.page = this.page + 1;
                },

                remove_duplicate: function () {
                    vm.orders.sort(dynamicSort("time"));
                    for (var i = 0; i < vm.orders.length; i++) {
                        var order_id = vm.orders[i].id;
                        for (var j = 0; j < vm.orders.length; j++) {
                            var tmp_order_id = vm.orders[j].id;
                            if (order_id == tmp_order_id && i != j) {
                                vm.orders.splice(j, 1);
                            }

                        }
                    }
                }
            },


        });


    </script>

    <script src="{{url('')}}/admin_assets/assets/general/js/chat/chat.js"></script>

@endpush

