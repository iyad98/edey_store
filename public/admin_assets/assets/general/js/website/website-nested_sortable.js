// var item = [{
//     id : 0,
//     body: "A cool folder",
//     children: [
//         {
//             id: 1,
//             body: "A cool sub-folder 1",
//             children: [
//                 {
//                     id: 2,
//                     body: "A cool sub-sub-folder 1"
//                 },
//                 {
//                     id: 3,
//                     body: "A cool sub-sub-folder 2"
//                 }
//             ]
//         },
//         {
//             id: 4,
//             body: "This one is not that cool"
//         }
//     ]
// },
//     {
//         id: 5,
//         body: "A cool folder"
//     }
// ];
// var items =
//     [
//         {"id": 1, "body": "go shopping"}, // no parent for first item
//         {"id": 2, "body": "go to the mall", "parent": 1},
//         {"id": 3, "body": "go to the supermarket", "parent": 1},
//         {"id": 4, "body": "buy shoes", "parent": 2},
//         {"id": 5, "body": "buy tomatoes", "parent": 3},
//         {"id": 6, "body": "buy rice"}
//     ];
//
// var tree = new Tree(items);
// tree = Object.values(tree.nodes);
// let list_items = [];
// tree.forEach(function (t) {
//     if(!t.hasOwnProperty('parent')) {
//         list_items.push(t);
//     }
// });

Vue.component('node-tree', {
    name: 'node',
    props: ['node', 'index'],
    methods: {
        delete_item : function (event) {
            $(event.target).closest('.dd-item').remove();
         //   $(event.target).parent().parent().parent().parent().remove();
        }
    },
    template: '<li class="dd-item list-group-item"  :data-id="node.id">' +
    '<div class="dd-handle">' +
    '<div class="dd-handle_" style="font-weight: bold" v-text="node.name"></div>' +
    ' <div class="row">\n' +
    '                                            <div class="col-sm-6">الاسم المستعار(عربي)</div>\n' +
    '                                            <div class="col-sm-6">الاسم المستعار(انجليزي)</div>\n' +
    '                                        </div>\n' +
    '                                        <div class="row">\n' +
    '                                            <div class="col-sm-6"><input type="text" class="nickname_ar form-control"\n' +
    '                                                                         v-model="node.nickname_ar"></div>\n' +
    '                                            <div class="col-sm-6"><input type="text" class="nickname_en form-control"\n' +
    '                                                                         v-model="node.nickname_en"></div>\n' +
    '                                        </div>' +
    '' +
    '' +
    ' <span style="float: left;"><a @click="delete_item($event)" href="javascript:;"\n' +
    '                                                                      \n' +
    '                                                                      class="delete m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"\n' +
    '                                                                      title="Delete">\n' +
    '                                                    <i class="la la-remove"></i>\n' +
    '                                            </a>\n' +
    '                                        </span>' +
    '</div>' +
    '' +
    '<ol class="dd-list list-group  list-group mt-3 mb-3">' +
    '' +
    '  <node v-for="child in node.children"  :node="child"></node>' +
    '  </ol>' +
    '</li>' +
    '' +
    ''
});


Vue.component('tree', {
    props: ['treeData'],
    methods: {},
    template: '<div class="dd">' +
    '    <ol class="dd-list list-group mt-5 mb-5">' +
    '       <node-tree  v-for="(tree , index) in treeData"  :index="index" :node="tree"></node-tree>' +
    '    </ol>' +
    '  </div>',
});

