Template.main.helpers({

});

Template.main.events({
    'click .logout': function() {
        Meteor.logout();
        Router.go('guests');
    },
});
