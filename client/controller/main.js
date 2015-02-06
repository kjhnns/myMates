Template.main.helpers({

});

Template.main.events({
    'click .js-logout': function() {
        Meteor.logout();

        Router.go('main');
    },
});
