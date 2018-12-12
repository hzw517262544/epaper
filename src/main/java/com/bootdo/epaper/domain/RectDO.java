package com.bootdo.epaper.domain;

import java.io.Serializable;
import java.util.Date;



/**
 * 
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-12 18:40:04
 */
public class RectDO implements Serializable {
	private static final long serialVersionUID = 1L;
	
	//
	private Integer id;
	//
	private String verorder;
	//
	private Date publishdate;
	//
	private String picfile;
	//
	private String pdffile;
	//
	private String banmian;
	//
	private String rect;
	//
	private Integer isfrist;
	//
	private Integer publishid;

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
	public void setPicfile(String picfile) {
		this.picfile = picfile;
	}
	/**
	 * 获取：
	 */
	public String getPicfile() {
		return picfile;
	}
	/**
	 * 设置：
	 */
	public void setPdffile(String pdffile) {
		this.pdffile = pdffile;
	}
	/**
	 * 获取：
	 */
	public String getPdffile() {
		return pdffile;
	}
	/**
	 * 设置：
	 */
	public void setBanmian(String banmian) {
		this.banmian = banmian;
	}
	/**
	 * 获取：
	 */
	public String getBanmian() {
		return banmian;
	}
	/**
	 * 设置：
	 */
	public void setRect(String rect) {
		this.rect = rect;
	}
	/**
	 * 获取：
	 */
	public String getRect() {
		return rect;
	}
	/**
	 * 设置：
	 */
	public void setIsfrist(Integer isfrist) {
		this.isfrist = isfrist;
	}
	/**
	 * 获取：
	 */
	public Integer getIsfrist() {
		return isfrist;
	}
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
}
