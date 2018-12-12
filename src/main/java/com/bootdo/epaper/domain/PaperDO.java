package com.bootdo.epaper.domain;

import java.io.Serializable;
import java.util.Date;



/**
 * 
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-11 21:48:48
 */
public class PaperDO implements Serializable {
	private static final long serialVersionUID = 1L;
	
	//
	private Integer publishid;
	//
	private Date publishdate;
	//
	private Long id;

	private Integer parentid;

	private String verorder;

	/**
	 * 设置：
	 */
	public void setPublishid(Integer publishid) {
		this.publishid = publishid;
	}
	/**
	 * 获取：
	 */
	public Integer getPublishid() {
		return publishid;
	}
	/**
	 * 设置：
	 */
	public void setPublishdate(Date publishdate) {
		this.publishdate = publishdate;
	}
	/**
	 * 获取：
	 */
	public Date getPublishdate() {
		return publishdate;
	}
	/**
	 * 设置：
	 */
	public void setId(Long id) {
		this.id = id;
	}
	/**
	 * 获取：
	 */
	public Long getId() {
		return id;
	}

	public Integer getParentid() {
		return parentid;
	}

	public void setParentid(Integer parentid) {
		this.parentid = parentid;
	}

	public String getVerorder() {
		return verorder;
	}

	public void setVerorder(String verorder) {
		this.verorder = verorder;
	}
}
