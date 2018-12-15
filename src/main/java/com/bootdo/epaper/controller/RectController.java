package com.bootdo.epaper.controller;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import com.bootdo.common.utils.DateUtils;
import com.bootdo.epaper.domain.PaperDO;
import com.bootdo.epaper.service.PaperService;
import org.apache.commons.lang3.StringUtils;
import org.apache.shiro.authz.annotation.RequiresPermissions;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.ui.Model;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

import com.bootdo.epaper.domain.RectDO;
import com.bootdo.epaper.service.RectService;
import com.bootdo.common.utils.PageUtils;
import com.bootdo.common.utils.Query;
import com.bootdo.common.utils.R;

/**
 * 
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-12 18:40:04
 */
 
@Controller
@RequestMapping("/epaper/rect")
public class RectController {
	@Autowired
	private RectService rectService;

	@Autowired
	private PaperService paperService;
	
	@GetMapping()
//	@RequiresPermissions("epaper:rect:rect")
	String Rect(){
	    return "epaper/rect/rect";
	}
	
	@ResponseBody
	@GetMapping("/list")
//	@RequiresPermissions("epaper:rect:rect")
	public PageUtils list(@RequestParam Map<String, Object> params){
		//查询列表数据
//        Query query = new Query(params);
		List<RectDO> rectList = rectService.list(params);
		int total = rectService.count(params);
		PageUtils pageUtils = new PageUtils(rectList, total);
		return pageUtils;
	}
	
	@GetMapping("/add/{publishid}")
//	@RequiresPermissions("epaper:rect:add")
	String add(@PathVariable("publishid")Long publishid,Model model){
		PaperDO paperDO = paperService.get(publishid);
		model.addAttribute("paperDO",paperDO);
	    return "epaper/Admin/AddPaper";
	}

	@GetMapping("/edit/{id}")
//	@RequiresPermissions("epaper:rect:edit")
	String edit(@PathVariable("id") Integer id,Model model){
		RectDO rect = rectService.get(id);
		model.addAttribute("rect", rect);
	    return "epaper/rect/edit";
	}
	
	/**
	 * 保存
	 */
	@ResponseBody
	@PostMapping("/save")
//	@RequiresPermissions("epaper:rect:add")
	public R save( RectDO rect){
		Map<String,Object> parMap = new HashMap<String,Object>();
		parMap.put("publishdate",rect.getPublishdate());
		parMap.put("verorder",rect.getVerorder());
		int count = rectService.count(parMap);
		if(count>0){
			return R.error().put("msg","此期刊中已添加该报纸版面"+rect.getVerorder()+"，请添加其他版面！");
		}
		if(rectService.save(rect)>0){
			return R.ok();
		}
		return R.error();
	}
	/**
	 * 修改
	 */
	@ResponseBody
	@RequestMapping("/update")
//	@RequiresPermissions("epaper:rect:edit")
	public R update( RectDO rect){
		if(rect.getIsfrist()==null){
			rect.setIsfrist(0);
		}
		rectService.update(rect);
		return R.ok();
	}
	
	/**
	 * 删除
	 */
	@PostMapping( "/remove")
	@ResponseBody
//	@RequiresPermissions("epaper:rect:remove")
	public R remove( Integer id){
		if(rectService.remove(id)>0){
		return R.ok();
		}
		return R.error();
	}
	
	/**
	 * 删除
	 */
	@PostMapping( "/batchRemove")
	@ResponseBody
//	@RequiresPermissions("epaper:rect:batchRemove")
	public R remove(@RequestParam("ids[]") Integer[] ids){
		rectService.batchRemove(ids);
		return R.ok();
	}

	@ResponseBody
	@GetMapping("/listByPublishId")
//	@RequiresPermissions("epaper:rect:rect")
	public List<RectDO> listByPublishId(@RequestParam Integer publishid){
		//查询列表数据
		Map<String,Object> parMap = new HashMap<String,Object>();
		parMap.put("publishid",publishid);
		List<RectDO> rectList = rectService.list(parMap);
		return rectList;
	}
	
}
