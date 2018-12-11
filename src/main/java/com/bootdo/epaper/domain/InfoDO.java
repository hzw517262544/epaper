package com.bootdo.epaper.domain;

import java.io.Serializable;
import java.util.Date;



/**
 * 
 * 
 * @author chglee
 * @email 1992lcg@163.com
 * @date 2018-12-11 20:14:45
 */
public class InfoDO implements Serializable {
	private static final long serialVersionUID = 1L;
	
	//
	private Integer id;
	//
	private String websitename;
	//
	private String websiteurl;
	//
	private String websitetcp;
	//
	private String webtongji;
	//
	private String websitekeyword;
	//
	private String websiteintr;
	//
	private String websitecopyinfo;
	//
	private Integer message;
	//
	private String powered;

	/**
	 * 设置：
	 */
	public void setId(Integer id) {
		this.id = id;
	}
	/**
	 * 获取：
	 */
	public Integer getId() {
		return id;
	}
	/**
	 * 设置：
	 */
	public void setWebsitename(String websitename) {
		this.websitename = websitename;
	}
	/**
	 * 获取：
	 */
	public String getWebsitename() {
		return websitename;
	}
	/**
	 * 设置：
	 */
	public void setWebsiteurl(String websiteurl) {
		this.websiteurl = websiteurl;
	}
	/**
	 * 获取：
	 */
	public String getWebsiteurl() {
		return websiteurl;
	}
	/**
	 * 设置：
	 */
	public void setWebsitetcp(String websitetcp) {
		this.websitetcp = websitetcp;
	}
	/**
	 * 获取：
	 */
	public String getWebsitetcp() {
		return websitetcp;
	}
	/**
	 * 设置：
	 */
	public void setWebtongji(String webtongji) {
		this.webtongji = webtongji;
	}
	/**
	 * 获取：
	 */
	public String getWebtongji() {
		return webtongji;
	}
	/**
	 * 设置：
	 */
	public void setWebsitekeyword(String websitekeyword) {
		this.websitekeyword = websitekeyword;
	}
	/**
	 * 获取：
	 */
	public String getWebsitekeyword() {
		return websitekeyword;
	}
	/**
	 * 设置：
	 */
	public void setWebsiteintr(String websiteintr) {
		this.websiteintr = websiteintr;
	}
	/**
	 * 获取：
	 */
	public String getWebsiteintr() {
		return websiteintr;
	}
	/**
	 * 设置：
	 */
	public void setWebsitecopyinfo(String websitecopyinfo) {
		this.websitecopyinfo = websitecopyinfo;
	}
	/**
	 * 获取：
	 */
	public String getWebsitecopyinfo() {
		return websitecopyinfo;
	}
	/**
	 * 设置：
	 */
	public void setMessage(Integer message) {
		this.message = message;
	}
	/**
	 * 获取：
	 */
	public Integer getMessage() {
		return message;
	}
	/**
	 * 设置：
	 */
	public void setPowered(String powered) {
		this.powered = powered;
	}
	/**
	 * 获取：
	 */
	public String getPowered() {
		return powered;
	}
}
