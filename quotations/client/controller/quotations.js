var ERROR_KEY = 'quotationsCreate';

Template.quotations.helpers({
    quotations: Quotations.find({}, {
        sort: {
            createdAt: -1
        }
    })
});

Template.quotations.created = function() {
    Session.set(ERROR_KEY, null);
};

Template.quotations.helpers({
    error: function() {
        return Session.get(ERROR_KEY);
    }
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
        }, function(err) {
            if (err) {
                Session.set(ERROR_KEY, err.message);
            } else {
                Session.set(ERROR_KEY, null);
            }
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
