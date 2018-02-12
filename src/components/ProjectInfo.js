import {h, Component} from 'preact';

class ProjectInfo extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: {},
      message: ''
    };
    this.clearDataBase = this.clearDataBase.bind(this);
    this.createGitStructure = this.createGitStructure.bind(this);
  }

  componentDidMount() {
    fetch("/", {
      method: "POST",
      body: `show_modules=${this.props.project}`,
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    }).then((response) => {
      return response.json();
    }).then((data) => {
      this.setState({data: data});
    }).catch((er)=> {
      console.log(er);
      this.setState({data: data});
    });
  }

  clearDataBase() {
    if (confirm("Are you sure? It's  " + this.props.project + " data base")) {
      fetch("/", {
        method: "POST",
        //what ever data you want to post with key value pair
        body: `clear_data_base=${this.props.project}`,
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      }).then((response) => {
        return response.text();
      }).then((data) => {
        this.setState({message: data});
      }).catch((er)=> {
        console.log(er);
        this.setState({message: er});
      });
    }
  }

  createGitStructure(){
    fetch("/", {
      method: "POST",
      //what ever data you want to post with key value pair
      body: `create_git_structure=${this.props.project}`,
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    }).then((response) => {
      return response.text();
    }).then((data) => {
      this.setState({message: data});
    }).catch((er)=> {
      this.setState({message: er});
    });
  }

  render() {
    let {data, message} = this.state
    return (
      <div className="project-info">
        <ul>
          <li>Project Name : {data.project_name}</li>
          <li>Shop Name : {data.shop_name}</li>
          <li>PS version : {data.prestashop_vesion}</li>
          <li>Create : {new Date(data.shop_create).toLocaleDateString()}</li>
          <li>Data base name : {data.data_base}</li>
        </ul>
        <p>Modules</p>
        <table>
          <tr>
            <th>name</th>
            <th>version</th>
          </tr>
          {
            data.modules ? data.modules.map((item)=> (
              <tr>
                <td>{item.name}</td>
                <td>{item.version}</td>
              </tr>
            )) : ''
          }
        </table>
        <button type="button" onClick={this.clearDataBase}>Clear data base</button>
        <button type="button" onClick={this.createGitStructure}>Create git structure</button>
        <p>{message}</p>
      </div>
    );
  }
}

export default ProjectInfo;