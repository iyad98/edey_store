function Tree(items) {
    // properties
    this.source = items;
    this.nodes = {};
    this.orphans = [];

    // process items
    items.forEach(this.addItem.bind(this));

}

Tree.prototype =
    {
        // properties
        root: null,
        nodes: null,
        orphans: null,

        // methods
        addItem: function (item, index) {
            // variables
            var node = this.makeNode(item);
            var parent = this.getNode(node.parent);

            // assign
            if (index === 0) {
                this.root = node;
            }
            else if (parent) {
                if (!parent.hasOwnProperty('children')) {
                    parent.children = [];
                }
                parent.children.push(node);
                parent.children = parent.children.sort(function(a, b) {
                    return parseFloat(a.order) - parseFloat(b.order);
                });

            }
            else {
                this.orphans.push(node);
            }

            // register node
            this.nodes[node.id] = node;

        },

        makeNode: function (item) {
            return JSON.parse(JSON.stringify(item));
        },

        getNode: function (id) {
            return this.nodes[id];
            // return this.nodes[id];
        }

    };