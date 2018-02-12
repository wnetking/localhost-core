import {h, Component} from 'preact';
import ProjectInfo from './ProjectInfo'

class Project extends Component {
  constructor(props) {
    super(props);
    this.state = {
      showInfo: false
    };
    this.handle = this.handle.bind(this);
  }

  handle() {
    this.setState({showInfo: !this.state.showInfo});
  }

  render() {
    return (
      <div className="col-xs-6 col-sm-3 col-md-2">
        <div className="project">
          <h5 onClick={this.handle}>{this.props.project.project_name}</h5>
          <a className="project-preview" href={this.props.project.project_link} style={`background-image: url(${this.props.project.preview})`}>
          </a>
          <ul className="buttons">
            <li className="admin">
              <a href={this.props.project.admin !== 'not_active' ? this.props.project.admin : '#'} title="Admin panel">
              </a>
            </li>
            <li className="helper">
              <a href={this.props.project.helper_link !== 'not_active' ? this.props.project.helper_link : '#'} title="Helper">
              </a>
            </li>
          </ul>
        </div>
        {!this.state.showInfo ? '' :
          <div>
            <ProjectInfo project={this.props.project.project_name}/>
            <span className="close" onClick={this.handle}>Close</span>
          </div>
        }
      </div>
    )
  }
}

export default Project;