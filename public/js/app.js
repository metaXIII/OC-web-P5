$("#login").submit(e => {
    if (!$("#username").val()) {
        alert("Vous n'avez pas rempli le champ username")
        $("#username").focus()
        e.preventDefault()
    }
    if (!$("#password").val() && $("#username").val()) {
        alert("Vous n'avez pas rempli le champ du mot de passe")
        $("#password").focus()
        e.preventDefault()
    }
})
