Meteor.methods({
    'createAccount': function(data) {
        //Do server side validation
        return Accounts.createUser({
            email: data.email,
            password: data.password,
            username: data.username,
            profile: data.profile
        });
    }
});
