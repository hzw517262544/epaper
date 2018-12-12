package com.bootdo.epaper.domain;

import java.io.Serializable;
import java.util.Date;



/**
 * 
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-12 19:45:57
 */
public class PaperDO implements Serializable {
	private static final long serialVersionUID = 1L;
	
	//
	private Integer publishid;
	//
	private Date publishdate;
	//
	private Long id;

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
}
