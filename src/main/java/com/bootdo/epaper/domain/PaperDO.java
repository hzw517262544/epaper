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
	private String publishdate;
	//
	private Long id;

	private String selected;


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

	public String getPublishdate() {
		return publishdate;
	}

	public void setPublishdate(String publishdate) {
		this.publishdate = publishdate;
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

	public String getSelected() {
		return selected;
	}

	public void setSelected(String selected) {
		this.selected = selected;
	}
}
