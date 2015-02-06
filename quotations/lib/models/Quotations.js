var schema = new SimpleSchema({
    quote: {
        type: String,
        max: 500
    },
    createdBy: { // ehm. by
        type: Object, // Laters gonna be the User model
        //optional: true,
        blackbox: true
            // defaultValue: { user: 'joh'}
    },
    createdAt: { // ehm. added
        type: Date,
        autoValue: function() {
            if (this.isInsert) {
                return new Date;
            } else if (this.isUpsert) {
                return {
                    $setOnInsert: new Date
                };
            } else {
                this.unset();
            }
        }
    },
    who: {
        type: String,
        optional: true,
        max: 100
    },
    where: {
        type: String,
        optional: true,
        max: 100
    }
});

Quotations = new Mongo.Collection("quotations");
Quotations.attachSchema(schema);
