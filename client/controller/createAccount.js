var ERRORS_KEY = 'createAccountErrors';

Template.createAccount.created = function() {
    Session.set(ERRORS_KEY, null);
};

Template.createAccount.helpers({
    error: function() {
        return Session.get(ERRORS_KEY);
    }
});

Template.createAccount.events({
    'submit': function(event, template) {
        event.preventDefault();
        var email = template.$('[name=email]').val(),
            password = template.$('[name=password]').val(),
            confirm = template.$('[name=confirm]').val(),
            username = template.$('[name=username]').val(),
            profile = {
                name: template.$('[name=name]').val()
            };

        var errors = {};

        if (!email) {
            Session.set(ERRORS_KEY, 'Email');
            return;
        }
        if (!password || confirm !== password) {
            Session.set(ERRORS_KEY, 'Passwort');
            return;
        }
        return Meteor.call('createAccount', {
            email: email,
            password: password,
            username: username,
            profile: profile
        }, function(err, userId) {
            if (err) {
                return Session.set(ERRORS_KEY, error.reason);
            }
            Router.go('main');
        });
    }
});
