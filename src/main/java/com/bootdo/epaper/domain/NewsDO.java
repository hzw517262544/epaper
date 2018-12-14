package com.bootdo.epaper.domain;

import java.io.Serializable;
import java.util.Date;



/**
 * 
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-13 19:26:44
 */
public class NewsDO implements Serializable {
	private static final long serialVersionUID = 1L;
	
	//
	private Integer id;
	//
	private String title;
	//
	private String content;
	//
	private String publishdate;
	//
	private String verorder;
	//
	private Integer verorderid;
	//
	private String come;
	//
	private String user;
	//
	private String infotime;
	//
	private Integer hits;
	//副标题
	private String subTitle;

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
	public void setTitle(String title) {
		this.title = title;
	}
	/**
	 * 获取：
	 */
	public String getTitle() {
		return title;
	}
	/**
	 * 设置：
	 */
	public void setContent(String content) {
		this.content = content;
	}
	/**
	 * 获取：
	 */
	public String getContent() {
		return content;
	}

	public String getPublishdate() {
		return publishdate;
	}

	public void setPublishdate(String publishdate) {
		this.publishdate = publishdate;
	}

	/**
	 * 设置：
	 */
	public void setVerorder(String verorder) {
		this.verorder = verorder;
	}
	/**
	 * 获取：
	 */
	public String getVerorder() {
		return verorder;
	}
	/**
	 * 设置：
	 */
	public void setVerorderid(Integer verorderid) {
		this.verorderid = verorderid;
	}
	/**
	 * 获取：
	 */
	public Integer getVerorderid() {
		return verorderid;
	}
	/**
	 * 设置：
	 */
	public void setCome(String come) {
		this.come = come;
	}
	/**
	 * 获取：
	 */
	public String getCome() {
		return come;
	}
	/**
	 * 设置：
	 */
	public void setUser(String user) {
		this.user = user;
	}
	/**
	 * 获取：
	 */
	public String getUser() {
		return user;
	}

	public String getInfotime() {
		return infotime;
	}

	public void setInfotime(String infotime) {
		this.infotime = infotime;
	}

	/**
	 * 设置：
	 */
	public void setHits(Integer hits) {
		this.hits = hits;
	}
	/**
	 * 获取：
	 */
	public Integer getHits() {
		return hits;
	}
	/**
	 * 设置：副标题
	 */
	public void setSubTitle(String subTitle) {
		this.subTitle = subTitle;
	}
	/**
	 * 获取：副标题
	 */
	public String getSubTitle() {
		return subTitle;
	}
}
