LearnObjects = new Mongo.Collection("learnobjects");

if (Meteor.isClient) {
    Template.body.helpers({
        learnObjects: LearnObjects.find({}, {sort: {createdAt: -1}})
    });

    Template.body.events({
        "submit .new-task": function(event) {
            // This function is called when the new task form is submitted
            var text = event.target.text.value;

            LearnObjects.insert({
                text: text,
                createdAt: new Date() // current time
            });

            // Clear form
            event.target.text.value = "";

            // Prevent default form submit
            return false;
        },
        "click .delete": function(event) {
            // This function is called when the new task form is submitted
            LearnObjects.remove({_id: event.target.dataset.id});
        }
    });
}

if (Meteor.isServer) {
    Meteor.startup(function() {
        // code to run on server at startup
    });
}
