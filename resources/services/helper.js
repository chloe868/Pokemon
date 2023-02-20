export default{
    displayWithCamelCase(name){
      var format = name.charAt(0).toUpperCase() + name.slice(1)
      return format
    },
    validatePassword(password) {
      const re = /^(?=.*[0-9])(?=.*[- ?!@#$%^&*\/\\])(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9- ?!@#$%^&*\/\\]{6,}$/
      return re.test(password)
    },
  }