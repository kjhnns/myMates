Template.quotations.helpers({
    quotations: Quotations.find({}, {
        sort: {
            createdAt: -1
        }
    })
});

Template.quotations.events({
    "submit .new-task": function(event, template) {
        var quote = template.$('[name=quote]').val(),
            where = template.$('[name=where]').val(),
            who = template.$('[name=who]').val();

        template.$('[name=quote]').val('');
        template.$('[name=where]').val('');
        template.$('[name=who]').val('');

        Quotations.insert({
            quote: quote,
            createdBy: {
                "user": who
            },
            who: who,
            where: where
        });

        return false;
    },
    "click .delete": function(event) {
        // This function is called when the new task form is submitted
        Quotations.remove({
            _id: event.target.dataset.id
        });
    }
});
