Meteor.methods({
    'createAccount': function(data) {
        return Accounts.createUser({
            email: data.email,
            password: data.password,
            username: data.username,
            profile: data.profile
        });
    }
});
