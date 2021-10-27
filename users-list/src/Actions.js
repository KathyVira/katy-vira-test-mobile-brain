import { useEffect, useState } from "react";

export const Actions = () => {
  let [users, setUsers] = useState([]);

    //userLength is for showing the Data Loading message.
  let [userLength, setUserLength] = useState(null);

  useEffect(() => {
    fetch("http://localhost/all-users.php")
      .then((res) => {return res.json();})
      .then((data) => {
        //   console.log(data);
        //   debugger;
           if (data) {
            setUsers(data.users.reverse());
            setUserLength(true);
           
            } else {          
            setUserLength(0);
            }
      })
      .catch((err) => {
        console.log(err);
      });
  }, []);

  // Inserting a new user into the database.
  const insertUser = (newUser) => {
    fetch("http://localhost/add-user.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(newUser),
    })
      .then((res) => {

        return res.json();
      })
      .then((data) => {
        if (data.id) {
          setUsers([
            {
              id: data.id,
              email: data.email,
              phone: data.phone,
              token: crypto.randomBytes(30).toString('hex'),
              ip: data.ip,
            },
            ...users,
          ]);
          setUserLength(true);
        } else {
          alert(data.msg);
        }
      })
      .catch((err) => {
        console.log(err);
      });
  };

  // Enabling the edit mode for a listed user.
  const editMode = (id) => {
    users = users.map((user) => {
      if (user.id === id) {
        user.isEditing = true;
        return user;
      }
      user.isEditing = false;
      return user;
    });
    setUsers(users);
  };

  // Cance the edit mode.
  const cancelEdit = (id) => {
    users = users.map((user) => {
      if (user.id === id) {
        user.isEditing = false;
        return user;
      }
      return user;
    });
    setUsers(users);
  };

  // Updating a user.
  const updateUser = (userData) => {
    fetch("http://localhost/update-user.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(userData),
    })
      .then((res) => {
        console.log(res);
        return res.json();
      })
      .then((data) => {
         
        if (data.success) {
          users = users.map((user) => {
            // if (user.id === userData.id) {
              user.id = userData.id;
              user.email = userData.email;
              user.phone = userData.phone;
              user.token = userData.token;
              user.ip = userData.ip;
            //   return user;
            // }
            return user;
          });
          setUsers(users);
        } else {
          alert(data.msg);
        }
      })
      .catch((err) => {
        console.log(err);
      });
  };

  // Deleting a user.
  const deleteUser = (theID) => {
      // filter outing the user.
    let userDeleted = users.filter((user) => {
      return user.id !== theID;
    });
    fetch("http://localhost/delete-user.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: theID }),
    })
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        if (data.success) {
          setUsers(userDeleted);
          if (users.length === 1) {
            setUserLength(0);
          }
        } else {
          alert(data.msg);
        }
      })
      .catch((err) => {
        console.log(err);
      });
  };




  return {
    users,
    editMode,
    cancelEdit,
    updateUser,
    insertUser,
    deleteUser,
    userLength,
  };
};
