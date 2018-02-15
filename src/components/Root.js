import { h, render } from "preact";
import { connect } from "preact-redux";
import t from "../translations";
import ProjectList from "./projects/components/ProjectList";
import Info from "./details/components/Info";
import FilterList from "./filter/components/FilterList";
import SettingButton from "./settings/components/SettingButton";
import Settings from "./settings/components/Settings";

const Root = ({ theme, hoverEffect, typeOfVeiw }) => (
  <div className={`root-element ${theme} ${hoverEffect} ${typeOfVeiw}`}>
    <div className="navbar-top">
      <FilterList />
      <span className="btn">|</span>
      <SettingButton title={"Settings"} />
    </div>
    <ProjectList />
    <Info />
    <Settings />
  </div>
);

export default connect(state => state.settings)(Root);
