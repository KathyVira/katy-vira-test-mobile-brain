import { Provider } from "./Context";
import { Actions } from "./Actions";
import UserTable from "./components/UserTable";

function App() {
  const data = Actions();

  
  return (
    <Provider value={data}>
      <div className="App row p-2 d-flex justify-content-center">
          <div className="d-flex justify-content-center">
                <h1>Users List</h1>
          </div>
        <div className="wrapper col-8">
          <section className="">
            <UserTable />
          </section>
         

            
        </div>
      </div>
    </Provider>
  );
}

export default App;